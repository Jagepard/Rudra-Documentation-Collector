<?php

declare(strict_types = 1);

/**
 * @author    : Jagepard <jagepard@yandex.ru">
 * @license   https://mit-license.org/ MIT
 */

namespace Rudra\Markdown\Creators;

class MarkdownCreator implements DocumentationCreatorInterface
{
    /**
     * @param string $outputPath
     * @return void
     */
    public function createDocs(string $outputPath): void
    {
        file_put_contents($outputPath, "## Table of contents\n", FILE_APPEND);
        file_put_contents($outputPath, data('header') . '<hr>', FILE_APPEND);
        file_put_contents($outputPath, data('body') . '<hr>', FILE_APPEND);
        file_put_contents(
            $outputPath, 
            "\n\n###### created with [Rudra-Documentation-Collector](#https://github.com/Jagepard/Rudra-Documentation-Collector)\n", 
            FILE_APPEND
        );
    }

    /**
     * @param string $fullClassName
     * @return string
     */
    public function createHeaderString(string $fullClassName): string
    {
        return '- [' . $fullClassName . '](#' . str_replace("\\", "_", strtolower($fullClassName)) . ')' . "\n";
    }

    /**
     * @param string $fullClassName
     * @return string
     */
    public function createBodyString(string $fullClassName): string
    {
        // Create a ReflectionClass instance to analyze the class structure.
        $class   = new \ReflectionClass($fullClassName);
        $methods = $class->getMethods();

        // Generate the header section with an anchor link for navigation.
        $header  = "\n\n" . '<a id="' . $this->getAnchorName($fullClassName) . '"></a>';
        $header .= "\n\n### Class: " . $fullClassName . "\n";

        // Initialize the Markdown table structure with headers.
        $table   = "| Visibility | Function |\n|:-----------|:---------|\n";

        // Loop through all methods of the class.
        foreach ($methods as $method) {
            // Get visibility modifiers (e.g., public, protected, static).
            $modifiers = implode(' ', \Reflection::getModifierNames($method->getModifiers()));

            // Start building the method signature.
            $signature = '`' . $method->getName() . '(';
            $params    = [];

            // Process each parameter of the method.
            foreach ($method->getParameters() as $param) {
                $type = '';

                if ($param->getType()) {
                    $reflectionType = $param->getType();

                    // Handle union types (e.g., string|int|string|null).
                    if ($reflectionType instanceof \ReflectionUnionType) {
                        $types = [];

                        // Extract each type from the union and store it in an array.
                        foreach ($reflectionType->getTypes() as $typePart) {
                            $typeName = (string)$typePart;
                            $types[] = $typeName;
                        }

                        // Join the types with '|' (escaped later).
                        $type = implode('|', $types);
                    } else {
                        // Handle single types (e.g., string, ?callable).
                        $type = (string)$reflectionType;

                        // Add '?' prefix for nullable types if not already present.
                        if ($reflectionType->allowsNull() && !str_starts_with($type, '?')) {
                            $type = '?' . $type;
                        }
                    }

                    // Escape '|' characters for Markdown compatibility.
                    $type = str_replace('|', '\|', $type);
                }

                // Append the parameter type and name to the list of parameters.
                $params[] = $type . ' $' . $param->getName();
            }

            // Join all parameters with commas and close the method signature.
            $signature .= implode(', ', $params) . ')';

            // Handle return type of the method.
            $returnType = $method->getReturnType();
            $returnTypeName = '';

            if ($returnType) {
                if ($returnType instanceof \ReflectionUnionType) {
                    $types = [];

                    // Extract each type from the union return type.
                    foreach ($returnType->getTypes() as $typePart) {
                        $types[] = (string)$typePart;
                    }

                    // Join the types with '|' (escaped later).
                    $returnTypeName = implode('|', $types);
                } else {
                    // Handle single return types (e.g., string, ?int).
                    $returnTypeName = (string)$returnType;

                    // Add '?' prefix for nullable return types if not already present.
                    if ($returnType->allowsNull() && !str_starts_with($returnTypeName, '?')) {
                        $returnTypeName = '?' . $returnTypeName;
                    }
                }

                // Escape '|' characters for Markdown compatibility.
                $returnTypeName = str_replace('|', '\|', $returnTypeName);

                // Append the return type to the method signature.
                $signature .= ': ' . $returnTypeName;
            }

            // Close the method signature with backticks.
            $signature .= '`';

            // Extract the description from the DocBlock comment.
            $docBlock   = '';

            if ($method->getDocComment()) {
                // Remove the leading /** and trailing */ from the DocBlock.
                $docBlockRaw = substr($method->getDocComment(), 3, -2);
                $lines = explode("\n", $docBlockRaw);
                $descriptionLines = [];

                foreach ($lines as $line) {
                    // Clean up the line by removing unnecessary characters (*, -, spaces).
                    $cleanLine = trim(str_replace(['*', '-', '  '], '', $line));

                    // Stop processing if we encounter a tag (e.g., @param, @return).
                    if (str_starts_with($cleanLine, '@')) {
                        break;
                    }

                    // Collect non-empty lines as part of the description.
                    if (!empty($cleanLine)) {
                        $descriptionLines[] = $cleanLine;
                    }
                }

                // Combine the description lines into a single string.
                if (!empty($descriptionLines)) {
                    $docBlock = implode(' ', $descriptionLines);
                }
            }

            // Combine the method signature and description into one column.
            $functionColumn = $signature . "<br>" . $docBlock;

            // Add the row to the Markdown table.
            $table .= "| {$modifiers} | {$functionColumn} |\n";
        }

        // Return the full Markdown output (header + table).
        return $header . $table;
    }

    /**
     * @param string $className
     * @return string
     */
    private function getAnchorName(string $className): string
    {
        return str_replace("\\", "_", strtolower($className));
    }
}

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
        $class   = new \ReflectionClass($fullClassName);
        $methods = $class->getMethods();
        $header  = "\n\n" . '<a id="' . $this->getAnchorName($fullClassName) . '"></a>';
        $header .= "\n\n### Class: " . $fullClassName . "\n";
        $table   = "| Visibility | Function |\n|:-----------|:---------|\n";

        foreach ($methods as $method) {
            // Get visibility modifiers (e.g., public, protected, static).
            $modifiers = implode(' ', \Reflection::getModifierNames($method->getModifiers()));
            $signature = $this->buildMethodSignature($method);
            $docBlock  = $this->extractDocBlockDescription($method);

            // Combine the method signature and description.
            $functionColumn = $signature . "<br>" . $docBlock;

            // Add the row to the Markdown table.
            $table .= "| {$modifiers} | {$functionColumn} |\n";
        }

        return $header . $table;
    }

    /**
     * Builds the method signature with parameters and return type.
     *
     * @param \ReflectionMethod $method
     * @return string
     */
    private function buildMethodSignature(\ReflectionMethod $method): string
    {
        $signature = '`' . $method->getName() . '(';
        $params    = [];

        foreach ($method->getParameters() as $param) {
            $params[] = $this->getParameterTypeAndName($param);
        }

        $signature .= implode(', ', $params) . ')';
        $returnType = $method->getReturnType();
        
        if ($returnType) {
            $returnTypeName = $this->getTypeAsString($returnType);
            $signature .= ': ' . $returnTypeName;
        }

        return $signature . '`';
    }

    /**
     * @param \ReflectionMethod $method
     * @return string
     */
    private function extractDocBlockDescription(\ReflectionMethod $method): string
    {
        // Return an empty string if no DocBlock is found.
        if (!$docBlock = $method->getDocComment()) {
            return '';
        }

        // Remove /** and */ from the DocBlock and split it into lines.
        $docBlockRaw = substr($docBlock, 3, -2);
        $lines = explode("\n", $docBlockRaw);
        $descriptionLines = [];

        foreach ($lines as $line) {
            // Clean the line: remove * and extra spaces/tabs.
            $cleanLine = trim(str_replace(['*', '  ', "\t"], '', $line));

            // Stop processing when encountering a tag (e.g., @param, @return).
            if (str_starts_with($cleanLine, '@')) {
                break;
            }

            // Escape `$` and `|` only if they are not inside backticks.
            $cleanLine = preg_replace_callback('/(`.*?`)|([\$|])/', function ($matches) {
                // If inside backticks, leave unchanged.
                if (!empty($matches[1])) {
                    return $matches[1];
                }
                // Otherwise, escape `$` or `|`.
                return '\\' . $matches[2];
            }, $cleanLine);

            // Add non-empty lines to the description.
            if (!empty($cleanLine)) {
                $descriptionLines[] = $cleanLine;
            }
        }

        // Join all description lines with <br> for Markdown compatibility.
        return implode('<br>', $descriptionLines);
    }

    /**
     * @param \ReflectionParameter $param
     * @return string
     */
    private function getParameterTypeAndName(\ReflectionParameter $param): string
    {
        $type = '';

        if ($param->getType()) {
            $type = $this->getTypeAsString($param->getType());
        }

        return $type . ' $' . $param->getName();
    }

    /**
     * Converts a ReflectionType to a string representation.
     *
     * @param \ReflectionType $type
     * @return string
     */
    private function getTypeAsString(\ReflectionType $type): string
    {
        if ($type instanceof \ReflectionUnionType) {
            $types = array_map(fn($typePart) => (string)$typePart, $type->getTypes());
            $typeString = implode('|', $types);
        } else {
            $typeString = (string)$type;

            // Add '?' prefix for nullable types if not already present.
            if ($type->allowsNull() && !str_starts_with($typeString, '?')) {
                $typeString = '?' . $typeString;
            }
        }

        // Escape '|' characters for Markdown compatibility.
        return str_replace('|', '\|', $typeString);
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

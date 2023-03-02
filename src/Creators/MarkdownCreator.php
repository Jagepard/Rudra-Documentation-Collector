<?php

/**
 * @author    : Jagepard <jagepard@yandex.ru">
 * @license   https://mit-license.org/ MIT
 */

namespace Rudra\Markdown\Creators;

class MarkdownCreator implements DocumentationCreatorInterface
{
    public function createDocs(string $outputPath): void
    {
        file_put_contents($outputPath, "## Table of contents\n", FILE_APPEND);
        file_put_contents($outputPath, data('header') . '<hr>', FILE_APPEND);
        file_put_contents($outputPath, data('body') . '<hr>', FILE_APPEND);
        file_put_contents(
            $outputPath, 
            "\n\n###### created with [Rudra-Markdown](#https://github.com/Jagepard/Rudra-Markdown)\n", 
            FILE_APPEND
        );
    }

    public function createHeaderString(string $fullClassName): string
    {
        return '- [' . $fullClassName . '](#' . str_replace("\\", "_", strtolower($fullClassName)) . ')' . "\n";
    }

    public function createBodyString(string $fullClassName): string
    {
        $class      = new \ReflectionClass($fullClassName);
        $methods    = $class->getMethods();
        $interfaces = $class->getInterfaceNames();
        $parent     = $class->getParentClass();
        $header     = "\n\n" . '<a id="' . $this->getAnchorName($fullClassName) . '"></a>' 
        . "\n\n" . '### Class: ' . $fullClassName . "\n";
        $table      = '| Visibility | Function |' . "\n" .
        '|:-----------|:---------|' . "\n";

        if ($parent) {
            $header .= "##### extends " . '[' . $parent->getName() . '](#' . $this->getAnchorName($parent->getName()) . ')' . "\n";
        }

        if (count($interfaces) > 0) {
            foreach ($interfaces as $interface) {
                $header .= "##### implements " . '[' . $interface . '](#' . $this->getAnchorName($interface) . ')' . "\n";
            }
        }

        foreach ($methods as $method) {
            $table .= '|' . implode(' ', \Reflection::getModifierNames($method->getModifiers())) .
                      '|' . '<em><strong>' . $method->getName() . '</strong>(';
            $params = $method->getParameters();

            foreach ($params as $param) {
                $table .= ' ' . $param->getType() . ' $' . $param->getName() . ' ';
            }

            $returnType = ($method->getReturnType()) ? ': ' . $method->getReturnType() : null;
            $table     .= ')' . $returnType . '</em><br>';
            $docBlock   = '';

            if ($method->getDocComment()) {
                $docBlock   = substr($method->getDocComment(), 3, -2);
                $docBlock   = str_replace("*", "", $docBlock);
                $docBlock   = str_replace("  ", "", $docBlock);
                $docBlock   = str_replace("-", "", $docBlock);
                $strings    = explode("\n", $docBlock);
                $newStrings = [];
    
                foreach ($strings as $string) {
                    if (ctype_space($string) or $string == '' or str_contains($string, "@")) {
                        continue;
                    }
    
                    $newStrings[] = $string;
                }
    
                $docBlock = implode("<br>", $newStrings);
            }

            $table .= $docBlock . '|' . "\n";
        }

        return $header . $table;
    }

    private function getAnchorName($className): string
    {
        return str_replace("\\", "_", strtolower($className));
    }
}
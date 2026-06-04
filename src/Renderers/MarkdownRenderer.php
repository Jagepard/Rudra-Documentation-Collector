<?php declare(strict_types = 1);

/**
 * This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at https://mozilla.org/MPL/2.0/.
 *
 * @author  Korotkov Danila (Jagepard) <jagepard@yandex.ru>
 * @license https://mozilla.org/MPL/2.0/  MPL-2.0
 */

namespace Rudra\Markdown\Renderers;

class MarkdownRenderer implements DocumentationRendererInterface
{
    /**
     * ---------------------------------------------------|
     * Generates and saves the full documentation document
     * ---------------------------------------------------|
     * Генерирует и сохраняет полный документ документации
     * ---------------------------------------------------|
     * 
     * @param  string $outputPath
     * @return void
     */
    #[\Override]
    public function renderDocs(string $outputPath): void
    {
        $content = "## Table of contents\n"
            . data('header') . "\n\n---\n\n"
            . data('body') . "\n\n---\n\n"
            . "###### created with [Rudra-Documentation-Collector](https://github.com/Jagepard/Rudra-Documentation-Collector)\n";

        file_put_contents($outputPath, $content);
    }

    /**
     * --------------------------------------------------------------------------------------|
     * Generates the header part of the documentation for a class (for the table of contents)
     * --------------------------------------------------------------------------------------|
     * Генерирует заголовочную часть документации для класса (для оглавления).
     * --------------------------------------------------------------------------------------|
     * 
     * @param  string $fullClassName
     * @return string
     */
    #[\Override]
    public function renderHeader(string $fullClassName): string
    {
        $anchor = str_replace('\\', '_', strtolower($fullClassName));
        return '- [' . $fullClassName . '](#' . $anchor . ')' . "\n";
    }

    /**
     * ------------------------------------------------------------------------|
     * Generates the main part of the documentation for a class (methods table)
     * ------------------------------------------------------------------------|
     * Генерирует основную часть документации для класса (таблица методов)
     * ------------------------------------------------------------------------|
     * 
     * @param  string $fullClassName
     * @return string
     */
    #[\Override]
    public function renderBody(string $fullClassName): string
    {
        $class   = new \ReflectionClass($fullClassName);
        $methods = $class->getMethods();
        $header  = "\n\n" . '<a id="' . $this->getAnchorName($fullClassName) . '"></a>'
                 . "\n\n### Class: " . $fullClassName . "\n";
        $table   = "| Visibility | Function |\n"
                 . "|:-----------|:---------|\n";

        foreach ($methods as $method) {
            $table .= $this->buildMethodRow($method);
        }

        return $header . $table;
    }

    /**
     * @param  \ReflectionMethod $method
     * @return string
     */
    private function buildMethodRow(\ReflectionMethod $method): string
    {
        $modifiers = implode(' ', \Reflection::getModifierNames($method->getModifiers()));
        $signature = $this->buildMethodSignature($method);
        $docBlock  = $this->extractDocBlock($method);

        return "| {$modifiers} | {$signature}<br>{$docBlock} |\n";
    }

    /**
     * @param  string $className
     * @return string
     */
    private function getAnchorName(string $className): string
    {
        return str_replace('\\', '_', strtolower($className));
    }

    /**
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
            $signature     .= ': ' . $returnTypeName;
        }

        return $signature . '`';
    }

    /**
     * @param \ReflectionMethod $method
     * @return string
     */
    private function extractDocBlock(\ReflectionMethod $method): string
    {
        $docComment = $method->getDocComment();
        if (!$docComment) {
            return '';
        }

        $lines = explode("\n", substr($docComment, 3, -2));
        $descriptionLines = [];

        foreach ($lines as $line) {
            $cleanLine = trim(str_replace(['*', '  ', "\t"], '', $line));

            // Останавливаемся на первом теге (@param, @return и т.д.)
            if (str_starts_with($cleanLine, '@')) {
                break;
            }

            // Экранируем `$` и `|` только вне обратных кавычек
            $cleanLine = preg_replace_callback(
                '/(`.*?`)|([\$|])/',
                fn($matches) => $matches[1] !== '' ? $matches[1] : '\\' . $matches[2],
                $cleanLine
            );

            if ($cleanLine !== '') {
                $descriptionLines[] = $cleanLine;
            }
        }

        return implode('<br>', $descriptionLines);
    }

    /**
     * @param \ReflectionParameter $param
     * @return string
     */
    private function getParameterTypeAndName(\ReflectionParameter $param): string
    {
        $type = $param->getType() ? $this->getTypeAsString($param->getType()) . ' ' : '';
        return $type . '$' . $param->getName();
    }

    /**
     * @param \ReflectionType $type
     * @return string
     */
    private function getTypeAsString(\ReflectionType $type): string
    {
        return str_replace('|', '\|', (string) $type);
    }
}

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

class HtmlRenderer implements DocumentationRendererInterface
{
    /**
     * CSS framework for styling HTML documentation.
     * Allowed values: 'bsp' (Bootstrap), 'ui' (UIkit), 'f' (Foundation)
     * ---------------------
     * CSS-фреймворк для оформления HTML-документации.
     * Допустимые значения: 'bsp' (Bootstrap), 'ui' (UIkit), 'f' (Foundation)
     */
    private string $cssFramework;

    /**
     * Sets the CSS framework for styling the generated HTML documentation
     * ----------------------
     * Устанавливает CSS-фреймворк для оформления генерируемой HTML-документации.
     *
     * @param string $cssFramework
     */
    public function __construct(string $cssFramework = 'bsp')
    {
        $this->cssFramework = $cssFramework ?: 'bsp';
        $allowed            = ['bsp', 'ui', 'f'];

        if (!in_array($this->cssFramework, $allowed, true)) {
            throw new \InvalidArgumentException(
                sprintf('Unsupported CSS framework "%s". Allowed: %s', $this->cssFramework, implode(', ', $allowed))
            );
        }
    }

    /**
     * Generates and saves the full documentation document
     * -------------------
     * Генерирует и сохраняет полный документ документации
     * 
     * @param  string $outputPath
     * @return void
     */
    #[\Override]
    public function renderDocs(string $outputPath): void
    {
        // Собираем весь документ в одну строку
        $content = $this->setHtmlHeader()
            . '<h2 id="table-of-contents">Table of contents</h2>'
            . data('header') . '<hr>'
            . data('body') . '<hr>'
            . '<h6>created with <a href="https://github.com/Jagepard/Rudra-Documentation-Collector">Rudra-Documentation-Collector</a></h6><br>'
            . $this->setHtmlFooter();

        file_put_contents($outputPath, $content);
    }

    /**
     * Generates the header part of the documentation for a class (for the table of contents)
     * ------------------
     * Генерирует заголовочную часть документации для класса (для оглавления).
     * 
     * @param  string $fullClassName
     * @return string
     */
    #[\Override]
    public function renderHeader(string $fullClassName): string
    {
        $anchor = $this->getAnchorName($fullClassName);
        return '- [' . $fullClassName . '](#' . $anchor . ')' . "\n";
    }

    /**
     * Generates the main part of the documentation for a class (methods table)
     * ------------------
     * Генерирует основную часть документации для класса (таблица методов)
     * 
     * @param  string $fullClassName
     * @return string
     */
    #[\Override]
    public function renderBody(string $fullClassName): string
    {
        $class = new \ReflectionClass($fullClassName);

        return $this->buildClassHeader($class, $fullClassName) 
             . $this->buildMethodsTable($class->getMethods());
    }

    /**
     * @param  \ReflectionClass $class
     * @param  string           $fullClassName
     * @return string
     */
    private function buildClassHeader(\ReflectionClass $class, string $fullClassName): string
    {
        $header = '<a id="' . $this->getAnchorName($fullClassName) . '"></a>' 
                . '<h3>Class: ' . $fullClassName . '</h3>';

        if ($parent  = $class->getParentClass()) {
            $header .= '<h5>extends <a href="#' . $this->getAnchorName($parent->getName()) . '">' . $parent->getName() . '</a></h5>';
        }

        foreach ($class->getInterfaceNames() as $interface) {
            $header .= '<h5>implements <a href="#' . $this->getAnchorName($interface) . '">' . $interface . '</a></h5>';
        }

        return $header;
    }

    /**
     * @param  array  $methods
     * @return string
     */
    private function buildMethodsTable(array $methods): string
    {
        $table = '
        <table class="' . $this->setTableClass() . '">
            <thead>
                <tr>
                    <th>Visibility</th>
                    <th>Function</th>
                </tr>
            </thead>
            <tbody>
        ';

        foreach ($methods as $method) {
            $table .= $this->buildMethodRow($method);
        }

        return $table . '</tbody></table>';
    }

    /**
     * @param  \ReflectionMethod $method
     * @return string
     */
    private function buildMethodRow(\ReflectionMethod $method): string
    {
        $modifiers = implode(' ', \Reflection::getModifierNames($method->getModifiers()));
        
        $params = array_map(function (\ReflectionParameter $param) {
            $type = $param->getType();
            return ($type ? $type . ' ' : '') . '$' . $param->getName();
        }, $method->getParameters());

        $returnType = $method->getReturnType() ? ': ' . $method->getReturnType() : '';
        $signature  = '<em><strong>' . $method->getName() . '</strong>(' . implode(', ', $params) . ')' . $returnType . '</em><br>';
        
        $docBlock = $this->extractDocBlock($method);

        return '<tr><td>' . $modifiers . '</td><td>' . $signature . $docBlock . '</td></tr>';
    }

    /**
     * @param  \ReflectionMethod $method
     * @return string
     */
    private function extractDocBlock(\ReflectionMethod $method): string
    {
        $docComment = $method->getDocComment();
        if (!$docComment) {
            return '';
        }

        $docBlock   = substr($docComment, 3, -2);
        $strings    = explode("\n", $docBlock);
        $newStrings = [];

        foreach ($strings as $string) {
            $clean = trim(str_replace(['*', "\t"], '', $string));
            if ($clean === '' || str_starts_with($clean, '@')) {
                continue;
            }
            $newStrings[] = $clean;
        }

        return implode('<br>', $newStrings);
    }

    /**
     * @param string $className
     * @return string
     */
    private function getAnchorName(string $className): string
    {
        return str_replace("\\", "_", strtolower($className));
    }

    /**
     * @return string
     */
    private function setHtmlHeader(): string
    {
        return match ($this->cssFramework) {

        'ui' => '<!DOCTYPE html>
<html>
<head>
    <title>Rudra Html Documentation</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/uikit@3.16.3/dist/css/uikit.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.16.3/dist/js/uikit.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.16.3/dist/js/uikit-icons.min.js"></script>
</head>
<body>
<div class="uk-container">',

        'f' => '<!DOCTYPE html>
<html>
<head>
    <title>Rudra Html Documentation</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/foundation-sites@6.7.5/dist/css/foundation.min.css" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/foundation-sites@6.7.5/dist/js/foundation.min.js" crossorigin="anonymous"></script>
</head>
<body>
<div class="grid-container">',

        default => '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Rudra Html Documentation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
</head>
<body>
<div class="container">'
        };
    }

    /**
     * @return string
     */
    private function setHtmlFooter(): string
    {
        return match ($this->cssFramework) {
            'ui', 'f' => '</div></body></html>',
            default   => '
                    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
                    </div>
                  </body>
                </html>
            '
        };
    }

    /**
     * @return string
     */
    private function setTableClass(): string
    {
        return match ($this->cssFramework) {
            'ui'    => 'uk-table uk-table-striped',
            'f'     => 'stack',
            default => 'table table-striped'
        };
    }
}

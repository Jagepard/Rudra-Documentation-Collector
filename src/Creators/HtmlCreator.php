<?php

declare(strict_types = 1);

/**
 * @author    : Jagepard <jagepard@yandex.ru">
 * @license   https://mit-license.org/ MIT
 */

namespace Rudra\Markdown\Creators;

class HtmlCreator implements DocumentationCreatorInterface
{
    private string $frameworkType;

    /**
     * @param string $frameworkType
     */
    public function __construct(string $frameworkType = 'bsp')
    {
        $this->frameworkType = $frameworkType;
    }

    /**
     * @param string $outputPath
     * @return void
     */
    public function createDocs(string $outputPath): void
    {
        file_put_contents($outputPath, $this->setHtmlHeader(), FILE_APPEND);
        file_put_contents($outputPath, '<h2 id="table-of-contents">Table of contents</h2>', FILE_APPEND);
        file_put_contents($outputPath, data('header') . '<hr>', FILE_APPEND);
        file_put_contents($outputPath, data('body') . '<hr>', FILE_APPEND);
        file_put_contents(
            $outputPath, 
            '<h6>created with <a href="https://github.com/Jagepard/Rudra-Documentation-Collector">Rudra-Documentation-Collector</a></h6><br>', 
            FILE_APPEND
        );

        file_put_contents($outputPath, $this->setHtmlFooter(), FILE_APPEND);
    }

    /**
     * @param string $fullClassName
     * @return string
     */
    public function createHeaderString(string $fullClassName): string
    {
        return '<p><a href="#' . str_replace("\\", "_", strtolower($fullClassName)) . '">' . $fullClassName . '</a></p>';
    }

    /**
     * @param string $fullClassName
     * @return string
     */
    public function createBodyString(string $fullClassName): string
    {
        $class      = new \ReflectionClass($fullClassName);
        $methods    = $class->getMethods();
        $interfaces = $class->getInterfaceNames();
        $parent     = $class->getParentClass();
        $header     = '<a id="' . $this->getAnchorName($fullClassName) . '"></a>' 
        . '<h3>Class: ' . $fullClassName . '</h3>';
        $table      = '
        <table class="' . $this->setTableClass() . '">
            <thead>
                <tr>
                    <th>Visibility</th>
                    <th>Function</th>
                </tr>
            </thead>
            <tbody>
        ';

        if ($parent) {
            $header .= '<h5>extends <a href="#' . $this->getAnchorName($parent->getName()) . '">' . $parent->getName() . '</a></h5>';
        }

        if (count($interfaces) > 0) {
            foreach ($interfaces as $interface) {
                $header .= '<h5>implements <a href="#' . $this->getAnchorName($interface) . '">' . $interface . '</a></h5>';
            }
        }

        foreach ($methods as $method) {
            $table .= '<tr><td>' . implode(' ', \Reflection::getModifierNames($method->getModifiers())) . '</td>' . 
            '<td><em><strong>' . $method->getName() . '</strong>(';
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

            $table .= $docBlock . '</td></tr>';
        }

        return $header . $table . '</table>';
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
        switch ($this->frameworkType) {
            case 'ui': 
                return '
                <!DOCTYPE html>
                <html>
                    <head>
                        <title>Rudra Html Documentation</title>
                        <meta charset="utf-8">
                        <meta name="viewport" content="width=device-width, initial-scale=1">
        
                        <!-- UIkit CSS -->
                        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/uikit@3.16.3/dist/css/uikit.min.css" />
                        
                        <!-- UIkit JS -->
                        <script src="https://cdn.jsdelivr.net/npm/uikit@3.16.3/dist/js/uikit.min.js"></script>
                        <script src="https://cdn.jsdelivr.net/npm/uikit@3.16.3/dist/js/uikit-icons.min.js"></script>
                    </head>
                    <body>
                    <div class="uk-container">
                ';
                case 'f': 
                    return '
                    <!DOCTYPE html>
                    <html>
                        <head>
                            <title>Rudra Html Documentation</title>
                            <meta charset="utf-8">
                            <meta name="viewport" content="width=device-width, initial-scale=1">
            
                            <!-- Compressed CSS -->
                            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/foundation-sites@6.7.5/dist/css/foundation.min.css" crossorigin="anonymous">
                            
                            <!-- Compressed JavaScript -->
                            <script src="https://cdn.jsdelivr.net/npm/foundation-sites@6.7.5/dist/js/foundation.min.js" crossorigin="anonymous"></script>
                        </head>
                        <body>
                        <div class="grid-container">
                    ';
            default:
                return '
                <!doctype html>
                <html lang="en">
                  <head>
                    <meta charset="utf-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1">
                    <title>Rudra Html Documentation</title>
                    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
                  </head>
                  <body>
                  <div class="container">
                ';
        }
    }

    /**
     * @return string
     */
    private function setHtmlFooter(): string
    {
        switch ($this->frameworkType) {
            case 'ui':
            case 'f': 
                return '</div></body></html>';
            default:
                return '
                    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
                    </div>
                  </body>
                </html>                
                ';
        }
    }

    /**
     * @return string
     */
    private function setTableClass(): string
    {
        switch ($this->frameworkType) {
            case 'ui': 
                return 'uk-table uk-table-striped';
            case 'f': 
                return 'stack';
            default:
                return 'table table-striped';
        }
    }
}

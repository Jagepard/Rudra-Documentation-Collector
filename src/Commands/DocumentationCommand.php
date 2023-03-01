<?php

declare(strict_types = 1);

/**
 * @author    : Jagepard <jagepard@yandex.ru">
 * @license   https://mit-license.org/ MIT
 */

namespace Rudra\Markdown;

use Rudra\Cli\ConsoleFacade as Cli;
use Rudra\Container\Facades\Rudra;

class DocumentationCommand
{
    public function actionIndex(): void
    {
        $reflection = new \ReflectionClass(\Composer\Autoload\ClassLoader::class);
        $dir        = dirname(dirname(dirname($reflection->getFileName())));

        Cli::printer("Enter source directory: ", "cyan");
        $sourceDir = trim(fgets(fopen("php://stdin", "r")));
        $inputPath = $dir . '/' . $sourceDir;

        if (!is_dir($inputPath)) {
            throw new \InvalidArgumentException();
        }

        Cli::printer("Enter file name: ", "cyan");
        $fileName   = trim(fgets(fopen("php://stdin", "r")));
        $outputPath = $dir . '/' . $fileName . '.md';

        $this->scandir($inputPath, $outputPath);
        $this->collectMarkdown($outputPath);
    }

    protected function collectMarkdown(string $outputPath): void
    {
        file_put_contents($outputPath, "## Table of contents\n", FILE_APPEND);
        file_put_contents($outputPath, data('header') . '<hr>', FILE_APPEND);
        file_put_contents($outputPath, data('body') . '<hr>', FILE_APPEND);
        file_put_contents(
            $outputPath, 
            "\n######<em>created with [Rudra-Markdown ](#https://github.com/Jagepard/Rudra-Markdown)</em>\n", 
            FILE_APPEND
        );
    }

    protected function scandir(string $inputPath, string $outputPath): void
    {
        $directory = array_diff(scandir($inputPath), array('..', '.'));

        foreach($directory as $item) {
            if (str_contains($item, ".php")) {
                if (ctype_upper($item[0])) {

                    $fileContent = file_get_contents($inputPath . '/' . $item);
                    $className   = str_replace(".php", "", $item);

                    if (preg_match('/namespace[\\s]+([A-Za-z0-9\\\\]+?);/sm', $fileContent, $match)) {

                        $fullClassName = $match[1] . "\\" . $className;

                        if (class_exists($fullClassName) or interface_exists($fullClassName) or trait_exists($fullClassName)) {
                            $this->buildDocumentation($outputPath, $fullClassName);
                        }
                    }
                }
            } else {
                $subDir = $inputPath . '/' . $item;

                if (is_dir($subDir)) {   
                    $this->scandir($subDir, $outputPath);
                }
            }
        }
    }

    protected function buildDocumentation(string $outputPath, string $fullClassName):  void
    {
        $this->setHeader($fullClassName);
        $this->setBody($fullClassName);
    }

    protected function setHeader(string $fullClassName): void
    {
        if (Rudra::data()->has('header')) {
            data([
                'header' => data('header') . $this->createHeaderString($fullClassName)
            ]);
            return;
        }

        data([
            'header' => $this->createHeaderString($fullClassName)
        ]);
    }

    private function createHeaderString(string $fullClassName): string
    {
        return '- [' . $fullClassName . '](#' . str_replace("\\", "_", strtolower($fullClassName)) . ')' . "\n";
    }

    protected function setBody(string $fullClassName): void
    {
        if (Rudra::data()->has('body')) {
            data([
                'body' => data('body') . $this->createBodyString($fullClassName)
            ]);
            return;
        }

        data([
            'body' => $this->createBodyString($fullClassName)
        ]);
    }

    private function createBodyString(string $fullClassName): string
    {
        $header = "\n\n" . '<a id="' . str_replace("\\", "_", strtolower($fullClassName)) . '"></a>' 
                  . "\n\n" . '### Class: ' . $fullClassName  . "\n";
        $table  = '| Visibility | Function |' . "\n" .
                  '|:-----------|:---------|' . "\n";

        $class   = new \ReflectionClass($fullClassName);
        $methods = $class->getMethods();

        foreach ($methods as $method) {
            $table .= '|' . implode(' ', \Reflection::getModifierNames($method->getModifiers())) .
                      '|' . '<em><strong>' . $method->getName() . '</strong>(';

            $params = $method->getParameters();

            foreach ($params as $param) {
                $table .= ' ' . $param->getType() . ' $' . $param->getName() . ' ';
            }

            $returnType = ($method->getReturnType()) ? ': ' .  $method->getReturnType() : null;
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

            $table   .= $docBlock . '|' . "\n";
        }

        return $header . $table;
    }
}

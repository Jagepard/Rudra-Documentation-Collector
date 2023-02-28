<?php

namespace D\Commands;

use Rudra\Cli\ConsoleFacade as Cli;
use Rudra\Container\Facades\Rudra;

class DocumentationCommand
{
    public function actionIndex()
    {
        $dir = dirname(dirname(__DIR__));

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
        file_put_contents($outputPath, '## Table of contents' . PHP_EOL, FILE_APPEND);
        file_put_contents($outputPath, data('header') . '<hr>', FILE_APPEND);
        file_put_contents($outputPath, data('body') . '<hr>', FILE_APPEND);
    }

    protected function scandir($inputPath, $outputPath) 
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

    protected function buildDocumentation($outputPath, $fullClassName)
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
        return '- [' . $fullClassName . '](#' . str_replace("\\", "_", strtolower($fullClassName)) . ')' . PHP_EOL;
    }

    protected function setBody($fullClassName): void
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
        $header = '<a id="' . str_replace("\\", "_", strtolower($fullClassName)) . '"></a>' 
                  . PHP_EOL . '### Class: ' . $fullClassName  . PHP_EOL;
        $table  = '| Visibility | Function |' . PHP_EOL .
                  '|:-----------|:---------|' . PHP_EOL;

        $class   = new \ReflectionClass($fullClassName);
        $methods = $class->getMethods();

        foreach ($methods as $method) {
            $table .= '|' . implode(' ', \Reflection::getModifierNames($method->getModifiers())) .
                      '|' . $method->getName() . '(';

            $params = $method->getParameters();

            foreach ($params as $param) {
                $table .= ' ' . $param->getType() . ' $' . $param->getName() . ' ';
            }

            $table .= ')|' . PHP_EOL;
        }

        return $header . $table;
    }
}

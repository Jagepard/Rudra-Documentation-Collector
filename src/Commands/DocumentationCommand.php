<?php

declare(strict_types = 1);

/**
 * @author    : Jagepard <jagepard@yandex.ru">
 * @license   https://mit-license.org/ MIT
 */

namespace Rudra\Markdown\Commands;

use Rudra\Cli\ConsoleFacade as Cli;
use Rudra\Container\Facades\Rudra;
use Rudra\Markdown\Creators\MarkdownCreator;
use Rudra\Markdown\Creators\DocumentationCreatorInterface;
use Rudra\Markdown\Creators\HtmlCreator;

class DocumentationCommand
{
    protected DocumentationCreatorInterface $docCreator;

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
        $fileName = trim(fgets(fopen("php://stdin", "r")));

        Cli::printer("Enter output type: ", "magneta");
        Cli::printer("(Html: html)[Markdowm: md]: ", "cyan");
        $fileType = trim(fgets(fopen("php://stdin", "r")));

        if ($fileType === 'html') {
            Cli::printer("Сhoose a framework: ", "magneta");
            Cli::printer("(Uikit: ui)[Bootstrap: bsp]: ", "cyan");
            $frameworkType    = trim(fgets(fopen("php://stdin", "r")));
            $this->docCreator = new HtmlCreator($frameworkType);
            $outputPath       = $dir . '/' . $fileName . '.html';
        } else {
            $this->docCreator = new MarkdownCreator();
            $outputPath       = $dir . '/' . $fileName . '.md';
        }

        $this->scandir($inputPath, $outputPath);
        $this->docCreator->createDocs($outputPath);

        Cli::printer("Documentation: " . $outputPath . " created\n", "green");
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
                            $this->setData($fullClassName);
                            $this->setData($fullClassName, "body");
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

    protected function setData(string $fullClassName, string $type = 'header'): void
    {
        $methodName = "create" . ucfirst($type) . "String";

        if (Rudra::data()->has($type)) {
            data([
                $type => data($type) . $this->docCreator->{$methodName}($fullClassName)
            ]);
            return;
        }

        data([$type => $this->docCreator->{$methodName}($fullClassName)]);
    }
}

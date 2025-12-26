<?php

declare(strict_types = 1);

/**
 * This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at https://mozilla.org/MPL/2.0/.
 *
 * @author  Korotkov Danila (Jagepard) <jagepard@yandex.ru>
 * @license https://mozilla.org/MPL/2.0/  MPL-2.0
 */

namespace Rudra\Markdown\Command;

use Rudra\Container\Facades\Rudra;
use Rudra\Cli\ConsoleFacade as Cli;
use Rudra\Markdown\Creators\HtmlCreator;
use Rudra\Markdown\Creators\MarkdownCreator;
use Rudra\Markdown\Creators\DocumentationCreatorInterface;

class MakeDocumentation
{
    private DocumentationCreatorInterface $docCreator;

    public function actionIndex(): void
    {
        $reflection = new \ReflectionClass(\Composer\Autoload\ClassLoader::class);
        $dir        = dirname(dirname(dirname($reflection->getFileName())));

        Cli::printer("Enter source directory: ", "magneta");
        $sourceDir = trim(fgets(fopen("php://stdin", "r")));
        $inputPath = $dir . '/' . $sourceDir;

        if (!is_dir($inputPath)) {
            throw new \InvalidArgumentException();
        }

        Cli::printer("Enter file name: ", "magneta");
        $fileName = trim(fgets(fopen("php://stdin", "r")));

        Cli::printer("Enter output type: ", "magneta");
        Cli::printer("(Html: html)[Markdowm: md]: ", "magneta");
        $fileType = trim(fgets(fopen("php://stdin", "r")));

        if ($fileType === 'html') {
            Cli::printer("Сhoose a framework: ", "magneta");
            Cli::printer("(Foundation: f, Uikit: ui)[Bootstrap: bsp]: ", "magneta");
            $frameworkType    = trim(fgets(fopen("php://stdin", "r")));
            $this->docCreator = new HtmlCreator($frameworkType);
            $outputPath       = $dir . '/' . $fileName . '.html';
        } else {
            $this->docCreator = new MarkdownCreator();
            $outputPath       = $dir . '/' . $fileName . '.md';
        }

        $this->scandir($inputPath, $outputPath);
        $this->docCreator->createDocs($outputPath);

        Cli::printer("✅ Documentation: " . $outputPath . " created\n", "green");
    }

    /**
     * Recursively scans a directory for PHP classes and processes files with uppercase filenames.
     * 
     * @param  string $inputPath
     * @param  string $outputPath
     * @return void
     */
    private function scandir(string $inputPath, string $outputPath): void
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

    /**
     * Generates and appends documentation content for a class based on the specified type.
     * 
     * @param  string $fullClassName
     * @param  string $type
     * @return void
     */
    private function setData(string $fullClassName, string $type = 'header'): void
    {
        $methodName = "create" . ucfirst($type) . "String";

        if (Rudra::shared()->has($type)) {
            data([
                $type => data($type) . $this->docCreator->{$methodName}($fullClassName)
            ]);
            return;
        }

        data([$type => $this->docCreator->{$methodName}($fullClassName)]);
    }
}

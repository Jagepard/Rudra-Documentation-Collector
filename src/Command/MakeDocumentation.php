<?php declare(strict_types = 1);

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
use Rudra\Markdown\Renderers\HtmlRenderer;
use Rudra\Markdown\Renderers\MarkdownRenderer;
use Rudra\Markdown\Renderers\DocumentationRendererInterface;

class MakeDocumentation
{
    private DocumentationRendererInterface $docCreator;

    public function actionIndex(): void
    {
        $reflection  = new \ReflectionClass(\Composer\Autoload\ClassLoader::class);
        $projectRoot = dirname($reflection->getFileName(), 3);

        Cli::printer("Enter source directory (relative to root, e.g., 'src') [src]: ", "magneta");
        $sourceDir = trim(fgets(STDIN)) ?: 'src';
        $inputPath = $projectRoot . '/' . ltrim($sourceDir, '/');

        if (!is_dir($inputPath)) {
            throw new \InvalidArgumentException("Directory not found: {$inputPath}");
        }

        Cli::printer("Enter file name (without extension) [docs]: ", "magneta");
        $fileName = trim(fgets(STDIN)) ?: 'docs';

        Cli::printer("Enter output type (html/md) [md]: ", "magneta");
        $fileType = strtolower(trim(fgets(STDIN))) ?: 'md';

        if ($fileType === 'html') {
            Cli::printer("Choose a framework (f/ui) [bsp]: ", "magneta");
            $frameworkType = strtolower(trim(fgets(STDIN))) ?: 'bsp';
            
            $this->docCreator = new HtmlRenderer($frameworkType);
            $outputPath       = $projectRoot . '/' . $fileName . '.html';
        } else {
            $this->docCreator = new MarkdownRenderer();
            $outputPath       = $projectRoot . '/' . $fileName . '.md';
        }

        data(['header' => '', 'body' => '']);
        $this->scandir($inputPath, $outputPath);
        $this->docCreator->renderDocs($outputPath);

        Cli::printer("✅ Documentation created: " . $outputPath . "\n", "green");
    }

    /**
     * Recursively scans a directory for PHP classes,
     * interfaces, and traits, and accumulates documentation for them.
     * -----------------
     * Рекурсивно сканирует директорию в поисках PHP-классов,
     * интерфейсов и трейтов, и накапливает документацию по ним.
     *
     * @param string $inputPath
     */
    private function scandir(string $inputPath): void
    {
        $items = scandir($inputPath);
        if ($items === false) {
            return;
        }

        foreach ($items as $item) {
            if ($item === '.' || $item === '..') {
                continue;
            }

            $fullPath = $inputPath . DIRECTORY_SEPARATOR . $item;

            if (is_dir($fullPath)) {
                $this->scandir($fullPath);
                continue;
            }

            // Фильтр: только PHP-файлы, имя с заглавной буквы
            if (!str_ends_with($item, '.php') || !ctype_upper($item[0])) {
                continue;
            }

            $fileContent = file_get_contents($fullPath);
            if ($fileContent === false) {
                continue;
            }

            $className = pathinfo($item, PATHINFO_FILENAME);

            if (!preg_match('/^namespace\s+([A-Za-z0-9\\\\]+);/m', $fileContent, $match)) {
                continue;
            }

            $fullClassName = $match[1] . '\\' . $className;

            if (class_exists($fullClassName) || interface_exists($fullClassName) || trait_exists($fullClassName)) {
                $this->setData($fullClassName, 'header');
                $this->setData($fullClassName, 'body');
            }
        }
    }

    /**
     * Generates and appends documentation content for a class based on the specified type
     * ------------------
     * Генерирует и добавляет контент документации для класса на основе указанного типа
     * 
     * @param  string $fullClassName
     * @param  string $type
     * @return void
     */
    private function setData(string $fullClassName, string $type = 'header'): void
    {
        $methodName  = 'render' . ucfirst($type);
        $content     = $this->docCreator->{$methodName}($fullClassName);
        $currentData = Rudra::shared()->has($type) ? data($type) : '';
        
        data([$type => $currentData . $content]);
    }
}

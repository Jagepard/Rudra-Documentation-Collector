<?php

/**
 * @author    : Jagepard <jagepard@yandex.ru">
 * @license   https://mit-license.org/ MIT
 */

namespace Rudra\Markdown\Creators;

interface DocumentationCreatorInterface
{
    /**
     * @param  string $outputPath
     * @return void
     */
    public function createDocs(string $outputPath): void;

    /**
     * @param  string $fullClassName
     * @return string
     */
    public function createHeaderString(string $fullClassName): string;

    /**
     * @param  string $fullClassName
     * @return string
     */
    public function createBodyString(string $fullClassName): string;
}

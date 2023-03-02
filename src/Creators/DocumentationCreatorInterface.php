<?php

/**
 * @author    : Jagepard <jagepard@yandex.ru">
 * @license   https://mit-license.org/ MIT
 */

namespace Rudra\Markdown\Creators;

interface DocumentationCreatorInterface
{
    public function createDocs(string $outputPath): void;
    public function createHeaderString(string $fullClassName): string;
    public function createBodyString(string $fullClassName): string;
}

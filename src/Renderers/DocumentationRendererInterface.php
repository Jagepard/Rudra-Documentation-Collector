<?php

/**
 * This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at https://mozilla.org/MPL/2.0/.
 *
 * @author  Korotkov Danila (Jagepard) <jagepard@yandex.ru>
 * @license https://mozilla.org/MPL/2.0/  MPL-2.0
 */

namespace Rudra\Markdown\Renderers;

interface DocumentationRendererInterface
{
    /**
     * Generates and saves the full documentation document
     * -------------------
     * Генерирует и сохраняет полный документ документации
     * 
     * @param  string $outputPath
     * @return void
     */
    public function renderDocs(string $outputPath): void;

    /**
     * Generates the header part of the documentation for a class (for the table of contents)
     * ------------------
     * Генерирует заголовочную часть документации для класса (для оглавления).
     * 
     * @param  string $fullClassName
     * @return string
     */
    public function renderHeader(string $fullClassName): string;

    /**
     * Generates the main part of the documentation for a class (methods table)
     * ------------------
     * Генерирует основную часть документации для класса (таблица методов)
     * 
     * @param  string $fullClassName
     * @return string
     */
    public function renderBody(string $fullClassName): string;
}

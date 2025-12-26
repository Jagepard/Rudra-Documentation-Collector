<?php

/**
 * This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at https://mozilla.org/MPL/2.0/.
 *
 * @author  Korotkov Danila (Jagepard) <jagepard@yandex.ru>
 * @license https://mozilla.org/MPL/2.0/  MPL-2.0
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

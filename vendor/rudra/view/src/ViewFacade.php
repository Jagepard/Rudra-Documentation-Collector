<?php

declare(strict_types=1);

/**
 * @author    : Jagepard <jagepard@yandex.ru">
 * @license   https://mit-license.org/ MIT
 */

namespace Rudra\View;

use Rudra\Container\Traits\FacadeTrait;

/**
 * @method static void setup(string $basePath, string $viewPath, ?string $cachePath, string $extension = "phtml")
 * @method static string view($path, array $data = [])
 * @method static cache(array $path, $fullPage = true)
 *
 * @see View
 */
final class ViewFacade
{
    use FacadeTrait;

    /**
     * Displays template
     * -----------------
     * Отображает шаблон
     *
     * @param  [type] $path
     * @param  array  $data
     * @return void
     */
    public static function render($path, array $data = []): void
    {
        echo self::view($path, $data);
    }
}

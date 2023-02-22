<?php

declare(strict_types=1);

/**
 * @author    : Jagepard <jagepard@yandex.ru">
 * @license   https://mit-license.org/ MIT
 */

namespace Rudra\View;

use Rudra\Container\Traits\SetRudraContainersTrait;

class View implements ViewInterface
{
    use SetRudraContainersTrait;

    /**
     * Absolute path to the templates folder
     * -------------------------------------
     * Абсолютный путь к папке шаблонов
     *
     * @var string
     */
    private string $viewPath;

    /**
     * Absolute path to the cache folder
     * ---------------------------------
     * Абсолютный путь к папке кеша
     *
     * @var string|null
     */
    private ?string $cachePath;

    /**
     * Template file extension
     * ------------------------
     * Расширение файла шаблона
     *
     * @var string
     */
    private string $extension;

    /**
     * Setup basic parameters
     * -----------------------------
     * Установка основных параметров
     *
     * @param  array $config
     * @return void
     */
    public function setup(string $basePath, string $viewPath, ?string $cachePath = null, string $extension = "phtml"): void 
    {
        $this->viewPath  = $basePath . $viewPath;
        $this->cachePath = $basePath . $cachePath;
        $this->basePath  = $basePath;
        $this->extension = $extension;
    }

    /**
     * Returns the html representation from the output buffer
     * Imports variables from the $data array into the template
     * When passing an array:
     *     the html view is created according to the first parameter
     *     and cache file according to the second
     * -------------------------------------------------------------------
     * Возвращает html представление из буфера вывода
     * Импортирует переменные из массива $data в шаблон
     * При передаче массива:
     *     создается html представление в соответствии с первым параметром 
     *     и файл кэша в соответствии со вторым
     * 
     * @param  [type]       $path
     * @param  array        $data
     * @return string|false
     */
    public function view($path, array $data = []): string|false
    {
        if (is_array($path)) {
            $output    = $this->view($path[0], $data);
            $cachePath = $this->cachePath . '/'. str_replace('.', '/', $path[1]) . '.' . $this->extension;

            file_put_contents($cachePath, $output);
            return $output;
        }

        $path = $this->viewPath . '/'. str_replace('.', '/', $path) . '.' . $this->extension;

        ob_start();

        if (count($data)) extract($data, EXTR_REFS);
        if (file_exists($path)) require $path;

        return ob_get_clean();
    }

    /**
     * Checks the cache file against the caching frequency,
     * if the cache is out of date, then it must be updated
     * The default caching interval time is specified in the configuration file
     * config/setting.local.yml for local development config/setting.production.yml for public release
     * Example: 'cache.time' => 'now',
     * The caching interval time can be passed as the second parameter $time
     * Example: '+1 day'
     * The value of $fullPage true interrupts further code processing if the data in the cache file is up-to-date
     * Example: cache('index', '+1 day', true); or cache('index', null, true);
     * ----------------------------------------------------------------------------------------------------------
     * Проверяет файл кэша на соответствие периодичности кэширования,
     * если кеш устарел, то он должен быть обновлен
     * Время периодичности кэширования по умолчанию указывается в файле конфигурации 
     * config/setting.local.yml для локальной разработки config/setting.production.yml для публичного размещения
     * Пример: 'cache.time' => 'now', 
     * Время периодичности кэширования можно передать вторым элементом массива $path[1]
     * Пример: '+1 day'
     * Значение $fullPage true прерывает дальнейшую обработку кода в случае актуальности данных в файле кэша
     * Пример: cache(['index', '+1 day'], true); или cache(['index'], true); // время  из конфигурвции
     *
     * @param  string      $path
     * @param  boolean     $fullPage
     * @return string|null
     */
    public function cache(array $path, $fullPage = false): ?string
    {
        $cachePath = $this->cachePath . '/' . str_replace('.', '/', $path[0]) . '.' . $this->extension;
        $cacheTime = $path[1] ?? $this->rudra()->config()->get('cache.time');

        if (file_exists($cachePath) && (strtotime($cacheTime, filemtime($cachePath)) > time())) {
            if ($fullPage) {
                echo file_get_contents($cachePath);
                exit();
            }

            return file_get_contents($cachePath);
        }

        return null;
    }
}

<?php

/**
 * @author    : Jagepard <jagepard@yandex.ru">
 * @license   https://mit-license.org/ MIT
 */

namespace Rudra\View;

use Rudra\Container\Interfaces\RudraInterface;

interface ViewInterface
{
    /**
     * Setup basic parameters
     * -----------------------------
     * Установка основных параметров
     *
     * @param  array $config
     * @return void
     */
    public function setup(string $basePath, string $viewPath, ?string $cachePath, string $extension = "phtml"): void;

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
    public function view($path, array $data = []): string|false;

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
    public function cache(array $path, $fullPage = false): ?string;

    /**
     * Service and Configuration Container
     * -----------------------------------
     * Контейнер сервисов и конфигураций
     *
     * @return RudraInterface
     */
    public function rudra(): RudraInterface;
}

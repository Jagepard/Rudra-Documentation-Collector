## Table of contents

- [\Rudra\View\View](#class-rudraviewview)
- [\Rudra\View\ViewFacade](#class-rudraviewviewfacade)
- [\Rudra\View\ViewInterface (interface)](#interface-rudraviewviewinterface)

<hr />
<a id="class-rudraviewview"></a>

### Class: \Rudra\View\View

| Visibility | Function |
|:-----------|:---------|
| public | <strong>__construct(</strong><em>\Rudra\Container\Interfaces\RudraInterface</em> <strong>$rudra</strong>)</strong> : <em>void</em> |
| public | <br><strong>cache(</strong><em>string/array</em> <strong>$path</strong>, <em>bool/boolean</em> <strong>$fullPage=false</strong>)</strong> : <em>string/null</em><hr /><em>Checks the cache file against the caching frequency, if the cache is out of date, then it must be updated <br />The default caching interval time is specified in the configuration file `config/setting.local.yml` for local development `config/setting.production.yml` for public release. Example: `'cache.time' => 'now'` <br>The caching interval time can be passed as the second parameter `$time`. Example: `'+1 day'` <br> The value of `$fullPage = true` interrupts further code processing if the data in the cache file is up-to-date <br> Example: `cache('index', '+1 day', true);` or `cache('index', null, true);` <hr /> Проверяет файл кэша на соответствие периодичности кэширования, если кеш устарел, то он должен быть обновлен Время периодичности кэширования по умолчанию указывается в файле конфигурации `config/setting.local.yml` для локальной разработки `config/setting.production.yml` для публичного размещения <br>Пример: `'cache.time' => 'now'` <br> Время периодичности кэширования можно передать вторым элементом массива `$path[1]` Пример: `'+1 day'` Значение `$fullPage = true` прерывает дальнейшую обработку кода в случае актуальности данных в файле кэша <br>Пример: `cache(['index', '+1 day'], true);` или `cache(['index'], true);` // время  из конфигурвции</em>|
| public | <strong>rudra()</strong> : <em>void</em> |
| public | <br><strong>setup(</strong><em>\string</em> <strong>$basePath</strong>, <em>\string</em> <strong>$viewPath</strong>, <em>\string</em> <strong>$cachePath=null</strong>, <em>\string</em> <strong>$extension='phtml'</strong>)</strong> : <em>void</em><hr /><em>Setup basic parameters <hr> Установка основных параметров</em>|
| public | <br><strong>view(</strong><em>\Rudra\View\[type]</em> <strong>$path</strong>, <em>array</em> <strong>$data=array()</strong>)</strong> : <em>string/false</em><hr /><em>Returns the html representation from the output buffer Imports variables from the `$data` array into the template When passing an array: the html view is created according to the first parameter and cache file according to the second <hr> Возвращает html представление из буфера вывода Импортирует переменные из массива `$data` в шаблон При передаче массива: создается html представление в соответствии с первым параметром и файл кэша в соответствии со вторым</em> |

*This class implements [\Rudra\View\ViewInterface](#interface-rudraviewviewinterface)*

<hr /><a id="class-rudraviewviewfacade"></a>

### Class: \Rudra\View\ViewFacade

| Visibility | Function |
|:-----------|:---------|
| public static | <strong>__callStatic(</strong><em>mixed</em> <strong>$method</strong>, <em>array</em> <strong>$parameters=array()</strong>)</strong> : <em>void</em> |
| public static | <br><strong>render(</strong><em>\Rudra\View\[type]</em> <strong>$path</strong>, <em>array</em> <strong>$data=array()</strong>)</strong> : <em>void</em><hr /><em>Displays template <hr> Отображает шаблон</em> |

<hr /><a id="interface-rudraviewviewinterface"></a>

### Interface: \Rudra\View\ViewInterface

| Visibility | Function |
|:-----------|:---------|
| public | <strong>cache(</strong><em>string/array</em> <strong>$path</strong>, <em>bool/boolean</em> <strong>$fullPage=false</strong>)</strong> : <em>string/null</em> |
| public | <strong>rudra()</strong> : <em>\Rudra\Container\Interfaces\RudraInterface</em>|
| public | <strong>setup(</strong><em>\string</em> <strong>$basePath</strong>, <em>\string</em> <strong>$viewPath</strong>, <em>\string</em> <strong>$cachePath</strong>, <em>\string</em> <strong>$extension='phtml'</strong>)</strong> : <em>void</em> |
| public | <strong>view(</strong><em>\Rudra\View\[type]</em> <strong>$path</strong>, <em>array</em> <strong>$data=array()</strong>)</strong> : <em>string/false</em> |


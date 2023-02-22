<?php

declare(strict_types=1);

/**
 * @author    : Jagepard <jagepard@yandex.ru">
 * @license   https://mit-license.org/ MIT
 *
 * phpunit src/tests/ControllerTest --coverage-html src/tests/coverage-html
 */

namespace Rudra\View\Tests;

use Rudra\Container\{Container, Facades\Rudra, Interfaces\RudraInterface};
use Rudra\View\ViewFacade as View;
use PHPUnit\Framework\TestCase as PHPUnit_Framework_TestCase;

class ViewTest extends PHPUnit_Framework_TestCase
{
    protected function setUp(): void
    {
        Rudra::binding([RudraInterface::class => Rudra::run()]);
        Rudra::services([View::class => View::class]);

        View::setup(dirname(__DIR__) . '/', "app/resources/tmpl");
    }

    /**
     * @runInSeparateProcess
     */
    public function testView()
    {
        $this->assertEquals('"Hello World!!!"', View::view("index", ["name" => "World"]));
        $this->assertEquals('"Hello John!!!"', View::view("index", ["name" => "John"]));
    }
}

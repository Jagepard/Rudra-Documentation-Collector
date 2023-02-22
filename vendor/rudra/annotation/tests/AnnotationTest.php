<?php

/**
 * @author    : Jagepard <jagepard@yandex.ru">
 * @license   https://mit-license.org/ MIT
 *
 * phpunit src/tests/ContainerTest --coverage-html src/tests/coverage-html
 */

namespace Rudra\Annotation\Tests;

use ReflectionClass;
use ReflectionMethod;
use PHPUnit\Framework\TestCase as PHPUnit_Framework_TestCase;
use Rudra\Annotation\{Annotation, AnnotationInterface, Tests\Stub\PageController};

class AnnotationTest extends PHPUnit_Framework_TestCase
{
    private AnnotationInterface $annotation;
    private string $docBlock = "    
        /**
         * @Routing(url = '')
         * @Defaults(name='user1', lastname = 'sample', age='0', address = {country : 'Russia'; state : 'Tambov'}, phone = '000-00000000')
         * @assertResult(false)
         * @Validate(name = 'min:150', phone = 'max:9')
         * @Middleware('Middleware', params = {int1 : '123'})
         */
         ";
    private array $result = [
        "Routing" => [["url" => ""]],
        "Defaults" => [
            [
                "name" => "user1",
                "lastname" => "sample",
                "age" => "0",
                "address" => [
                    "country" => "Russia",
                    "state" => "Tambov",
                ],
                "phone" => "000-00000000",
            ],
        ],
        "assertResult" => [["false"]],
        "Validate" => [
            [
                "name" => "min:150",
                "phone" => "max:9",
            ],
        ],
        "Middleware" => [
            [
                0 => "'Middleware'",
                "params" => [
                    "int1" => "123",
                ],
            ],
        ],
    ];

    protected function setUp(): void
    {
        $this->annotation = new Annotation();
    }

    private function getMethod(string $name): ReflectionMethod
    {
        $class = new ReflectionClass($this->annotation);
        $method = $class->getMethod($name);
        $method->setAccessible(true);

        return $method;
    }

    public function testParseAnnotations(): void
    {
        $parseAnnotations = $this->getMethod("parseAnnotations");
        $this->assertEquals($this->result, $parseAnnotations->invokeArgs($this->annotation, [$this->docBlock]));
    }

    public function testGetClassAnnotations(): void
    {
        $this->assertEquals($this->result, $this->annotation->getAnnotations(PageController::class));
    }

    public function testGetMethodAnnotations(): void
    {
        $this->assertEquals($this->result, $this->annotation->getAnnotations(PageController::class, "indexAction"));
    }

    public function testGetMethodAttributes(): void
    {
        $this->assertEquals($this->result, $this->annotation->getAttributes(PageController::class, "secondAction"));
    }
}

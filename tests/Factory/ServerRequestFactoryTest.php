<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Factory;

use Innmind\Http\{
    Factory\ServerRequestFactory,
    Factory\ServerRequestFactoryInterface,
    Factory\HeadersFactoryInterface,
    Factory\EnvironmentFactoryInterface,
    Factory\CookiesFactoryInterface,
    Factory\QueryFactoryInterface,
    Factory\FormFactoryInterface,
    Factory\FilesFactoryInterface,
    Message\ServerRequestInterface
};

class ServerRequestFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testMake()
    {
        $f = new ServerRequestFactory(
            $headers = $this->getMock(HeadersFactoryInterface::class),
            $env = $this->getMock(EnvironmentFactoryInterface::class),
            $cookies = $this->getMock(CookiesFactoryInterface::class),
            $query = $this->getMock(QueryFactoryInterface::class),
            $form = $this->getMock(FormFactoryInterface::class),
            $files = $this->getMock(FilesFactoryInterface::class)
        );

        $this->assertInstanceOf(ServerRequestFactoryInterface::class, $f);

        $_SERVER['SERVER_PROTOCOL'] = 'HTTP/1.1';
        $_SERVER['HTTP_HOST'] = 'localhost:8080';
        $_SERVER['REQUEST_URI'] = '/index.php';
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $r = $f->make();

        $this->assertInstanceOf(ServerRequestInterface::class, $r);
    }

    public function testDefault()
    {
        $this->assertInstanceOf(
            ServerRequestFactoryInterface::class,
            ServerRequestFactory::default()
        );
    }
}

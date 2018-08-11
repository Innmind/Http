<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Factory\ServerRequest;

use Innmind\Http\{
    Factory\ServerRequest\ServerRequestFactory,
    Factory\ServerRequestFactory as ServerRequestFactoryInterface,
    Factory\HeadersFactory,
    Factory\EnvironmentFactory,
    Factory\CookiesFactory,
    Factory\QueryFactory,
    Factory\FormFactory,
    Factory\FilesFactory,
    Message\ServerRequest
};
use PHPUnit\Framework\TestCase;

class ServerRequestFactoryTest extends TestCase
{
    public function testMake()
    {
        $f = new ServerRequestFactory(
            $headers = $this->createMock(HeadersFactory::class),
            $env = $this->createMock(EnvironmentFactory::class),
            $cookies = $this->createMock(CookiesFactory::class),
            $query = $this->createMock(QueryFactory::class),
            $form = $this->createMock(FormFactory::class),
            $files = $this->createMock(FilesFactory::class)
        );

        $this->assertInstanceOf(ServerRequestFactoryInterface::class, $f);

        $_SERVER['SERVER_PROTOCOL'] = 'HTTP/1.1';
        $_SERVER['HTTP_HOST'] = 'localhost:8080';
        $_SERVER['REQUEST_URI'] = '/index.php';
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $r = $f->make();

        $this->assertInstanceOf(ServerRequest::class, $r);
        $this->assertSame('http://localhost:8080/index.php', (string) $r->url());
    }

    public function testDefault()
    {
        $this->assertInstanceOf(
            ServerRequestFactoryInterface::class,
            ServerRequestFactory::default()
        );
    }
}

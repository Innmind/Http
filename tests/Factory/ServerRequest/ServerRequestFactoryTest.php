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
    Message\ServerRequest,
    Message\Query,
    Message\Form,
    Message\Files,
    Message\Environment,
    Message\Cookies,
    Headers,
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
        $headers
            ->expects($this->once())
            ->method('__invoke')
            ->willReturn(Headers::of());
        $query
            ->expects($this->once())
            ->method('__invoke')
            ->willReturn(Query::of());
        $form
            ->expects($this->once())
            ->method('__invoke')
            ->willReturn(Form::of());
        $files
            ->expects($this->once())
            ->method('__invoke')
            ->willReturn(Files::of());
        $cookies
            ->expects($this->once())
            ->method('__invoke')
            ->willReturn(new Cookies);
        $env
            ->expects($this->once())
            ->method('__invoke')
            ->willReturn(new Environment);

        $this->assertInstanceOf(ServerRequestFactoryInterface::class, $f);

        $_SERVER['SERVER_PROTOCOL'] = 'HTTP/1.1';
        $_SERVER['HTTP_HOST'] = 'localhost:8080';
        $_SERVER['REQUEST_URI'] = '/index.php';
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $r = ($f)();

        $this->assertInstanceOf(ServerRequest::class, $r);
        $this->assertSame('http://localhost:8080/index.php', (string) $r->url());
    }

    public function testMakeWithUser()
    {
        $factory = new ServerRequestFactory(
            $headers = $this->createMock(HeadersFactory::class),
            $environment = $this->createMock(EnvironmentFactory::class),
            $cookies = $this->createMock(CookiesFactory::class),
            $query = $this->createMock(QueryFactory::class),
            $form = $this->createMock(FormFactory::class),
            $files = $this->createMock(FilesFactory::class)
        );
        $headers
            ->expects($this->once())
            ->method('__invoke')
            ->willReturn(Headers::of());
        $query
            ->expects($this->once())
            ->method('__invoke')
            ->willReturn(Query::of());
        $form
            ->expects($this->once())
            ->method('__invoke')
            ->willReturn(Form::of());
        $files
            ->expects($this->once())
            ->method('__invoke')
            ->willReturn(Files::of());
        $cookies
            ->expects($this->once())
            ->method('__invoke')
            ->willReturn(new Cookies);
        $environment
            ->expects($this->once())
            ->method('__invoke')
            ->willReturn(new Environment);

        $this->assertInstanceOf(ServerRequestFactoryInterface::class, $factory);

        $_SERVER['SERVER_PROTOCOL'] = 'HTTP/1.1';
        $_SERVER['HTTP_HOST'] = 'localhost:8080';
        $_SERVER['REQUEST_URI'] = '/index.php';
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['PHP_AUTH_USER'] = 'john';
        $request = ($factory)();

        $this->assertInstanceOf(ServerRequest::class, $request);
        $this->assertSame('http://john@localhost:8080/index.php', (string) $request->url());
    }

    public function testMakeWithUserAndPassword()
    {
        $factory = new ServerRequestFactory(
            $headers = $this->createMock(HeadersFactory::class),
            $environment = $this->createMock(EnvironmentFactory::class),
            $cookies = $this->createMock(CookiesFactory::class),
            $query = $this->createMock(QueryFactory::class),
            $form = $this->createMock(FormFactory::class),
            $files = $this->createMock(FilesFactory::class)
        );
        $headers
            ->expects($this->once())
            ->method('__invoke')
            ->willReturn(Headers::of());
        $query
            ->expects($this->once())
            ->method('__invoke')
            ->willReturn(Query::of());
        $form
            ->expects($this->once())
            ->method('__invoke')
            ->willReturn(Form::of());
        $files
            ->expects($this->once())
            ->method('__invoke')
            ->willReturn(Files::of());
        $cookies
            ->expects($this->once())
            ->method('__invoke')
            ->willReturn(new Cookies);
        $environment
            ->expects($this->once())
            ->method('__invoke')
            ->willReturn(new Environment);

        $this->assertInstanceOf(ServerRequestFactoryInterface::class, $factory);

        $_SERVER['SERVER_PROTOCOL'] = 'HTTP/1.1';
        $_SERVER['HTTP_HOST'] = 'localhost:8080';
        $_SERVER['REQUEST_URI'] = '/index.php';
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['PHP_AUTH_USER'] = 'john';
        $_SERVER['PHP_AUTH_PW'] = 'duh';
        $request = ($factory)();

        $this->assertInstanceOf(ServerRequest::class, $request);
        $this->assertSame('http://john:duh@localhost:8080/index.php', (string) $request->url());
    }

    public function testDefault()
    {
        $this->assertInstanceOf(
            ServerRequestFactoryInterface::class,
            ServerRequestFactory::default()
        );
    }
}

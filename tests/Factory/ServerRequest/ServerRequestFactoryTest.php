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
    ServerRequest,
    ServerRequest\Query,
    ServerRequest\Form,
    ServerRequest\Files,
    ServerRequest\Environment,
    ServerRequest\Cookies,
    Headers,
};
use Innmind\TimeContinuum\Earth\Clock;
use Innmind\Filesystem\File\Content;
use PHPUnit\Framework\TestCase;

class ServerRequestFactoryTest extends TestCase
{
    public function testMake()
    {
        $_SERVER['SERVER_PROTOCOL'] = 'HTTP/1.1';
        $_SERVER['HTTP_HOST'] = 'localhost:8080';
        $_SERVER['REQUEST_URI'] = '/index.php';
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $f = new ServerRequestFactory(
            $headers = $this->createMock(HeadersFactory::class),
            static fn() => Content::none(),
            $env = $this->createMock(EnvironmentFactory::class),
            $cookies = $this->createMock(CookiesFactory::class),
            $query = $this->createMock(QueryFactory::class),
            $form = $this->createMock(FormFactory::class),
            $files = $this->createMock(FilesFactory::class),
            $_SERVER,
        );
        $headers
            ->expects($this->once())
            ->method('__invoke')
            ->willReturn(Headers::of());
        $query
            ->expects($this->once())
            ->method('__invoke')
            ->willReturn(Query::of([]));
        $form
            ->expects($this->once())
            ->method('__invoke')
            ->willReturn(Form::of([]));
        $files
            ->expects($this->once())
            ->method('__invoke')
            ->willReturn(Files::of([]));
        $cookies
            ->expects($this->once())
            ->method('__invoke')
            ->willReturn(Cookies::of());
        $env
            ->expects($this->once())
            ->method('__invoke')
            ->willReturn(Environment::of());

        $this->assertInstanceOf(ServerRequestFactoryInterface::class, $f);

        $r = ($f)();

        $this->assertInstanceOf(ServerRequest::class, $r);
        $this->assertSame('http://localhost:8080/index.php', $r->url()->toString());
    }

    public function testMakeWithUser()
    {
        $_SERVER['SERVER_PROTOCOL'] = 'HTTP/1.1';
        $_SERVER['HTTP_HOST'] = 'localhost:8080';
        $_SERVER['REQUEST_URI'] = '/index.php';
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['PHP_AUTH_USER'] = 'john';
        $factory = new ServerRequestFactory(
            $headers = $this->createMock(HeadersFactory::class),
            static fn() => Content::none(),
            $environment = $this->createMock(EnvironmentFactory::class),
            $cookies = $this->createMock(CookiesFactory::class),
            $query = $this->createMock(QueryFactory::class),
            $form = $this->createMock(FormFactory::class),
            $files = $this->createMock(FilesFactory::class),
            $_SERVER,
        );
        $headers
            ->expects($this->once())
            ->method('__invoke')
            ->willReturn(Headers::of());
        $query
            ->expects($this->once())
            ->method('__invoke')
            ->willReturn(Query::of([]));
        $form
            ->expects($this->once())
            ->method('__invoke')
            ->willReturn(Form::of([]));
        $files
            ->expects($this->once())
            ->method('__invoke')
            ->willReturn(Files::of([]));
        $cookies
            ->expects($this->once())
            ->method('__invoke')
            ->willReturn(Cookies::of());
        $environment
            ->expects($this->once())
            ->method('__invoke')
            ->willReturn(Environment::of());

        $this->assertInstanceOf(ServerRequestFactoryInterface::class, $factory);

        $request = ($factory)();

        $this->assertInstanceOf(ServerRequest::class, $request);
        $this->assertSame('http://john@localhost:8080/index.php', $request->url()->toString());
    }

    public function testMakeWithUserAndPassword()
    {
        $_SERVER['SERVER_PROTOCOL'] = 'HTTP/1.1';
        $_SERVER['HTTP_HOST'] = 'localhost:8080';
        $_SERVER['REQUEST_URI'] = '/index.php';
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['PHP_AUTH_USER'] = 'john';
        $_SERVER['PHP_AUTH_PW'] = 'duh';
        $factory = new ServerRequestFactory(
            $headers = $this->createMock(HeadersFactory::class),
            static fn() => Content::none(),
            $environment = $this->createMock(EnvironmentFactory::class),
            $cookies = $this->createMock(CookiesFactory::class),
            $query = $this->createMock(QueryFactory::class),
            $form = $this->createMock(FormFactory::class),
            $files = $this->createMock(FilesFactory::class),
            $_SERVER,
        );
        $headers
            ->expects($this->once())
            ->method('__invoke')
            ->willReturn(Headers::of());
        $query
            ->expects($this->once())
            ->method('__invoke')
            ->willReturn(Query::of([]));
        $form
            ->expects($this->once())
            ->method('__invoke')
            ->willReturn(Form::of([]));
        $files
            ->expects($this->once())
            ->method('__invoke')
            ->willReturn(Files::of([]));
        $cookies
            ->expects($this->once())
            ->method('__invoke')
            ->willReturn(Cookies::of());
        $environment
            ->expects($this->once())
            ->method('__invoke')
            ->willReturn(Environment::of());

        $this->assertInstanceOf(ServerRequestFactoryInterface::class, $factory);

        $request = ($factory)();

        $this->assertInstanceOf(ServerRequest::class, $request);
        $this->assertSame('http://john:duh@localhost:8080/index.php', $request->url()->toString());
    }

    public function testDefault()
    {
        $this->assertInstanceOf(
            ServerRequestFactoryInterface::class,
            ServerRequestFactory::default(new Clock),
        );
    }
}

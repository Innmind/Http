<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Factory\ServerRequest;

use Innmind\Http\{
    Factory\ServerRequestFactory,
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
use Innmind\TimeContinuum\Clock;
use Innmind\Filesystem\File\Content;
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class ServerRequestFactoryTest extends TestCase
{
    public function testMake()
    {
        $_SERVER['SERVER_PROTOCOL'] = 'HTTP/1.1';
        $_SERVER['HTTP_HOST'] = 'localhost:8080';
        $_SERVER['REQUEST_URI'] = '/index.php';
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $f = ServerRequestFactory::of(
            HeadersFactory::of(static fn() => Headers::of()),
            static fn() => Content::none(),
            EnvironmentFactory::of(static fn() => Environment::of()),
            CookiesFactory::of(static fn() => Cookies::of()),
            QueryFactory::of(static fn() => Query::of([])),
            FormFactory::of(static fn() => Form::of([])),
            FilesFactory::of(static fn() => Files::of([])),
            $_SERVER,
        );

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
        $factory = ServerRequestFactory::of(
            HeadersFactory::of(static fn() => Headers::of()),
            static fn() => Content::none(),
            EnvironmentFactory::of(static fn() => Environment::of()),
            CookiesFactory::of(static fn() => Cookies::of()),
            QueryFactory::of(static fn() => Query::of([])),
            FormFactory::of(static fn() => Form::of([])),
            FilesFactory::of(static fn() => Files::of([])),
            $_SERVER,
        );

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
        $factory = ServerRequestFactory::of(
            HeadersFactory::of(static fn() => Headers::of()),
            static fn() => Content::none(),
            EnvironmentFactory::of(static fn() => Environment::of()),
            CookiesFactory::of(static fn() => Cookies::of()),
            QueryFactory::of(static fn() => Query::of([])),
            FormFactory::of(static fn() => Form::of([])),
            FilesFactory::of(static fn() => Files::of([])),
            $_SERVER,
        );

        $request = ($factory)();

        $this->assertInstanceOf(ServerRequest::class, $request);
        $this->assertSame('http://john:duh@localhost:8080/index.php', $request->url()->toString());
    }

    public function testDefault()
    {
        $this->assertInstanceOf(
            ServerRequestFactory::class,
            ServerRequestFactory::native(Clock::live()),
        );
    }
}

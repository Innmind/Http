<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Message;

use Innmind\Http\{
    Message\Method,
    Exception\DomainException,
};
use PHPUnit\Framework\TestCase;
use Innmind\BlackBox\{
    PHPUnit\BlackBox,
    Set,
};

class MethodTest extends TestCase
{
    use BlackBox;

    public function testInterface()
    {
        $m = new Method('GET');

        $this->assertSame('GET', $m->toString());

        new Method('POST');
        new Method('PUT');
        new Method('PATCH');
        new Method('DELETE');
        new Method('OPTIONS');
        new Method('HEAD');
        new Method('TRACE');
        new Method('CONNECT');
    }

    public function testNamedConstructors()
    {
        $this
            ->forAll($this->methods())
            ->then(function($method) {
                $this->assertSame(
                    $method,
                    Method::{strtolower($method)}()->toString(),
                );
            });
    }

    public function testThrowWhenInvalidMethod()
    {
        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('get');

        new Method('get');
    }

    public function testOnlyOneInstancePerMethod()
    {
        $this
            ->forAll($this->methods())
            ->then(function($method) {
                $method = \strtolower($method);

                $this->assertSame(Method::$method(), Method::$method());
            });
    }

    public function methods(): Set
    {
        return Set\Elements::of(
            'GET',
            'POST',
            'PUT',
            'PATCH',
            'DELETE',
            'OPTIONS',
            'TRACE',
            'CONNECT',
            'HEAD',
            'LINK',
            'UNLINK',
        );
    }
}

<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Message;

use Innmind\Http\Message\Method;
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
        $m = Method::of('GET');

        $this->assertSame('GET', $m->toString());

        Method::of('POST');
        Method::of('PUT');
        Method::of('PATCH');
        Method::of('DELETE');
        Method::of('OPTIONS');
        Method::of('HEAD');
        Method::of('TRACE');
        Method::of('CONNECT');
    }

    public function testNamedConstructors()
    {
        $this
            ->forAll($this->methods())
            ->then(function($method) {
                $this->assertSame(
                    $method,
                    Method::{\strtolower($method)}()->toString(),
                );
            });
    }

    public function testThrowWhenInvalidMethod()
    {
        $this->expectException(\UnhandledMatchError::class);

        Method::of('get');
    }

    public function testOnlyOneInstancePerMethod()
    {
        $this
            ->forAll($this->methods())
            ->then(function($method) {
                $method = \strtolower($method);

                $this->assertEquals(Method::$method(), Method::$method());
            });
    }

    public function testEquals()
    {
        $this
            ->forAll($this->methods())
            ->then(function($method) {
                $this->assertTrue(
                    Method::of($method)->equals(Method::of($method)),
                );
            });
        $this
            ->forAll(
                $this->methods(),
                $this->methods(),
            )
            ->filter(fn($a, $b) => $a !== $b)
            ->then(function($a, $b) {
                $this->assertFalse(
                    Method::of($a)->equals(Method::of($b)),
                );
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

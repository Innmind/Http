<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http;

use Innmind\Http\Method;
use Innmind\BlackBox\{
    PHPUnit\BlackBox,
    PHPUnit\Framework\TestCase,
    Set,
};

class MethodTest extends TestCase
{
    use BlackBox;

    public function testNamedConstructors()
    {
        $this
            ->forAll($this->methods())
            ->then(function($method) {
                $this->assertSame(
                    $method,
                    Method::of($method)->toString(),
                );
            });
    }

    public function testThrowWhenInvalidMethod()
    {
        $this->expectException(\UnhandledMatchError::class);

        $_ = Method::of('get');
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

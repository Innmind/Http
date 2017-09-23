<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Message\Method;

use Innmind\Http\Message\{
    Method\Method,
    Method as MethodInterface
};
use PHPUnit\Framework\TestCase;

class MethodTest extends TestCase
{
    public function testInterface()
    {
        $m = new Method('GET');

        $this->assertInstanceOf(MethodInterface::class, $m);
        $this->assertSame('GET', (string) $m);

        new Method('POST');
        new Method('PUT');
        new Method('PATCH');
        new Method('DELETE');
        new Method('OPTIONS');
        new Method('HEAD');
        new Method('TRACE');
        new Method('CONNECT');
    }

    /**
     * @expectedException Innmind\Http\Exception\DomainException
     */
    public function testThrowWhenInvalidMethod()
    {
        new Method('get');
    }
}

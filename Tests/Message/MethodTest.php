<?php
declare(strict_types = 1);

namespace Innmind\Http\Tests\Message;

use Innmind\Http\Message\{
    Method,
    MethodInterface
};

class MethodTest extends \PHPUnit_Framework_TestCase
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
     * @expectedException Innmind\Http\Exception\InvalidArgumentException
     */
    public function testThrowWhenInvalidMethod()
    {
        new Method('get');
    }
}

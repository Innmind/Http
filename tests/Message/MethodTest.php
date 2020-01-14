<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Message;

use Innmind\Http\{
    Message\Method,
    Exception\DomainException,
};
use PHPUnit\Framework\TestCase;

class MethodTest extends TestCase
{
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

    /**
     * @dataProvider methods
     */
    public function testNamedConstructors($method)
    {
        $this->assertSame($method, Method::{strtolower($method)}()->toString());
    }

    public function testThrowWhenInvalidMethod()
    {
        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('get');

        new Method('get');
    }

    public function methods(): array
    {
        return [
            ['GET'],
            ['POST'],
            ['PUT'],
            ['PATCH'],
            ['DELETE'],
            ['OPTIONS'],
            ['TRACE'],
            ['CONNECT'],
            ['HEAD'],
            ['LINK'],
            ['UNLINK'],
        ];
    }
}

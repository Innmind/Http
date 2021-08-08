<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Message\Query;

use Innmind\Http\{
    Message\Query\Parameter,
    Exception\DomainException,
};
use PHPUnit\Framework\TestCase;

class ParameterTest extends TestCase
{
    public function testInterface()
    {
        $p = new Parameter('foo', '42');

        $this->assertSame('foo', $p->name());
        $this->assertSame('42', $p->value());
    }

    public function testThrowWhenEmptyName()
    {
        $this->expectException(DomainException::class);

        new Parameter('', '42');
    }
}

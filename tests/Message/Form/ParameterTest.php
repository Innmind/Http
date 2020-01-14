<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Message\Form;

use Innmind\Http\{
    Message\Form\Parameter,
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

    public function testThrowWhenValueNeitherStringNorArray()
    {
        $this->expectException(\TypeError::class);
        $this->expectExceptionMessage('Argument 2 must be of type string|array, integer given');

        new Parameter('foo', 42);
    }
}

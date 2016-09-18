<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Message\Query;

use Innmind\Http\Message\Query\{
    Parameter,
    ParameterInterface
};

class ParameterTest extends \PHPUnit_Framework_TestCase
{
    public function testInterface()
    {
        $p = new Parameter('foo', 42);

        $this->assertInstanceOf(ParameterInterface::class, $p);
        $this->assertSame('foo', $p->name());
        $this->assertSame(42, $p->value());
    }

    /**
     * @expectedException Innmind\Http\Exception\InvalidArgumentException
     */
    public function testThrowWhenEmptyName()
    {
        new Parameter('', 42);
    }
}

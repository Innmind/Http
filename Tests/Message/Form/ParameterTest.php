<?php
declare(strict_types = 1);

namespace Innmind\Http\Tests\Message\Form;

use Innmind\Http\Message\Form\{
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
}

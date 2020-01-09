<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Message\Form;

use Innmind\Http\Message\Form\{
    Parameter,
};
use PHPUnit\Framework\TestCase;

class ParameterTest extends TestCase
{
    public function testInterface()
    {
        $p = new Parameter('foo', 42);

        $this->assertSame('foo', $p->name());
        $this->assertSame(42, $p->value());
    }

    /**
     * @expectedException Innmind\Http\Exception\DomainException
     */
    public function testThrowWhenEmptyName()
    {
        new Parameter('', 42);
    }
}

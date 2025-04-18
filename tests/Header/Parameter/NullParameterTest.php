<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header\Parameter;

use Innmind\Http\Header\{
    Parameter\NullParameter,
    Parameter
};
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class NullParameterTest extends TestCase
{
    public function testInterface()
    {
        $p = new NullParameter;

        $this->assertInstanceOf(Parameter::class, $p);
        $this->assertSame('', $p->name());
        $this->assertSame('', $p->value());
        $this->assertSame('', $p->toString());
    }
}

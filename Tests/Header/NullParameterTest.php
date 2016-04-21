<?php
declare(strict_types = 1);

namespace Innmind\Http\Tests\Header;

use Innmind\Http\Header\{
    NullParameter,
    ParameterInterface
};

class NullParameterTest extends \PHPUnit_Framework_TestCase
{
    public function testInterface()
    {
        $p = new NullParameter;

        $this->assertInstanceOf(ParameterInterface::class, $p);
        $this->assertSame('', $p->name());
        $this->assertSame('', $p->value());
    }
}

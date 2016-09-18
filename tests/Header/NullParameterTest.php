<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

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
        $this->assertSame('', (string) $p);
    }
}

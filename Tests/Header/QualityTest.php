<?php
declare(strict_types = 1);

namespace Innmind\Http\Tests\Header;

use Innmind\Http\Header\{
    Quality,
    ParameterInterface
};

class QualityTest extends \PHPUnit_Framework_TestCase
{
    public function testInterface()
    {
        $p = new Quality('0.8');

        $this->assertInstanceOf(ParameterInterface::class, $p);
        $this->assertSame('q', $p->name());
        $this->assertSame('0.8', $p->value());
        $this->assertSame('q=0.8', (string) $p);
    }

    /**
     * @expectedException Innmind\Http\Exception\InvalidArgumentException
     */
    public function testThrowWhenInvalidQualityValue()
    {
        new Quality('foo');
    }
}

<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\Header\{
    Quality,
    ParameterInterface
};

class QualityTest extends \PHPUnit_Framework_TestCase
{
    public function testInterface()
    {
        $p = new Quality(0.8);

        $this->assertInstanceOf(ParameterInterface::class, $p);
        $this->assertSame('q', $p->name());
        $this->assertSame('0.8', $p->value());
        $this->assertSame('q=0.8', (string) $p);

        $this->assertSame('q=0', (string) new Quality(0));
    }

    /**
     * @dataProvider invalids
     * @expectedException Innmind\Http\Exception\InvalidArgumentException
     */
    public function testThrowWhenInvalidQualityValue($v)
    {
        new Quality($v);
    }

    public function invalids()
    {
        return [
            [-1],
            [2],
        ];
    }
}

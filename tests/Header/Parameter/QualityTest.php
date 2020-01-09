<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header\Parameter;

use Innmind\Http\Header\{
    Parameter\Quality,
    Parameter
};
use PHPUnit\Framework\TestCase;

class QualityTest extends TestCase
{
    public function testInterface()
    {
        $p = new Quality(0.8);

        $this->assertInstanceOf(Parameter::class, $p);
        $this->assertSame('q', $p->name());
        $this->assertSame('0.8', $p->value());
        $this->assertSame('q=0.8', $p->toString());

        $this->assertSame('q=0', (new Quality(0))->toString());
    }

    /**
     * @dataProvider invalids
     * @expectedException Innmind\Http\Exception\DomainException
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

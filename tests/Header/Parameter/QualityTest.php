<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header\Parameter;

use Innmind\Http\{
    Header\Parameter\Quality,
    Header\Parameter,
    Exception\DomainException,
};
use Innmind\BlackBox\PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;

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

    #[DataProvider('invalids')]
    public function testThrowWhenInvalidQualityValue($v)
    {
        $this->expectException(DomainException::class);
        $this->expectExceptionMessage((string) $v);

        new Quality($v);
    }

    public static function invalids()
    {
        return [
            [-1],
            [2],
        ];
    }
}

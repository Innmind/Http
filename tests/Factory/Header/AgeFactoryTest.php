<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\HeaderFactory,
    Factory\Header\AgeFactory,
    Header\Age,
    Exception\DomainException,
};
use Innmind\Immutable\Str;
use PHPUnit\Framework\TestCase;

class AgeFactoryTest extends TestCase
{
    public function testInterface()
    {
        $this->assertInstanceOf(
            HeaderFactory::class,
            new AgeFactory
        );
    }

    public function testMake()
    {
        $header = (new AgeFactory)(
            Str::of('Age'),
            Str::of('42'),
        );

        $this->assertInstanceOf(Age::class, $header);
        $this->assertSame('Age: 42', $header->toString());
    }

    public function testThrowWhenNotExpectedHeader()
    {
        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('foo');

        (new AgeFactory)(
            Str::of('foo'),
            Str::of(''),
        );
    }
}

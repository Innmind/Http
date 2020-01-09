<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\HeaderFactory,
    Factory\Header\AgeFactory,
    Header\Age
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
            new Str('Age'),
            new Str('42')
        );

        $this->assertInstanceOf(Age::class, $header);
        $this->assertSame('Age: 42', $header->toString());
    }

    /**
     * @expectedException Innmind\Http\Exception\DomainException
     */
    public function testThrowWhenNotExpectedHeader()
    {
        (new AgeFactory)(
            new Str('foo'),
            new Str('')
        );
    }
}

<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\HeaderFactory,
    Factory\Header\AcceptRangesFactory,
    Header\AcceptRanges,
    Exception\DomainException,
};
use Innmind\Immutable\Str;
use PHPUnit\Framework\TestCase;

class AcceptRangesFactoryTest extends TestCase
{
    public function testInterface()
    {
        $this->assertInstanceOf(
            HeaderFactory::class,
            new AcceptRangesFactory
        );
    }

    public function testMake()
    {
        $header = (new AcceptRangesFactory)(
            Str::of('Accept-Ranges'),
            Str::of('bytes'),
        );

        $this->assertInstanceOf(AcceptRanges::class, $header);
        $this->assertSame('Accept-Ranges: bytes', $header->toString());
    }

    public function testThrowWhenNotExpectedHeader()
    {
        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('foo');

        (new AcceptRangesFactory)(
            Str::of('foo'),
            Str::of(''),
        );
    }
}

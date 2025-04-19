<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\Header\LastModifiedFactory,
    Header\LastModified,
};
use Innmind\TimeContinuum\Clock;
use Innmind\Immutable\Str;
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class LastModifiedFactoryTest extends TestCase
{
    public function testMake()
    {
        $header = (new LastModifiedFactory(Clock::live()))(
            Str::of('Last-Modified'),
            Str::of('Tue, 15 Nov 1994 08:12:31 GMT'),
        )->match(
            static fn($header) => $header,
            static fn() => null,
        );

        $this->assertInstanceOf(LastModified::class, $header);
        $this->assertSame(
            'Last-Modified: Tue, 15 Nov 1994 08:12:31 GMT',
            $header->toString(),
        );
    }

    public function testReturnNothingWhenNotExpectedHeader()
    {
        $this->assertNull((new LastModifiedFactory(Clock::live()))(
            Str::of('foo'),
            Str::of(''),
        )->match(
            static fn($header) => $header,
            static fn() => null,
        ));
    }

    public function testReturnNothingWhenNotOfExpectedFormat()
    {
        $this->assertNull((new LastModifiedFactory(Clock::live()))(
            Str::of('Last-Modified'),
            Str::of('2020-01-01'),
        )->match(
            static fn($header) => $header,
            static fn() => null,
        ));
    }
}

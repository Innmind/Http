<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\Header\Factory,
    Header,
    Header\LastModified,
};
use Innmind\Time\Clock;
use Innmind\Immutable\Str;
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class LastModifiedFactoryTest extends TestCase
{
    public function testMake()
    {
        $header = Factory::new(Clock::live())(
            Str::of('Last-Modified'),
            Str::of('Tue, 15 Nov 1994 08:12:31 GMT'),
        );

        $this->assertInstanceOf(LastModified::class, $header);
        $this->assertSame(
            'Last-Modified: Tue, 15 Nov 1994 08:12:31 GMT',
            $header->normalize()->toString(),
        );
    }

    public function testReturnNothingWhenNotOfExpectedFormat()
    {
        $this->assertInstanceOf(
            Header::class,
            Factory::new(Clock::live())(
                Str::of('Last-Modified'),
                Str::of('2020-01-01'),
            ),
        );
    }
}

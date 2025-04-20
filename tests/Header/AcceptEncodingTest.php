<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\{
    Header\AcceptEncoding,
    Header,
    Header\Accept\Encoding,
    Header\Parameter\Quality
};
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class AcceptEncodingTest extends TestCase
{
    public function testInterface()
    {
        $h = Encoding::maybe('compress', new Quality(1))
            ->map(AcceptEncoding::of(...))
            ->match(
                static fn($header) => $header,
                static fn() => null,
            );

        $this->assertInstanceOf(Header\Custom::class, $h);
        $this->assertSame('Accept-Encoding: compress;q=1', $h->normalize()->toString());
    }

    public function testWithoutValues()
    {
        $this->assertSame('Accept-Encoding: ', AcceptEncoding::of()->normalize()->toString());
    }
}

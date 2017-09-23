<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\{
    Header\AcceptEncoding,
    Header,
    Header\AcceptEncodingValue,
    Header\Parameter\Quality
};
use Innmind\Immutable\Set;
use PHPUnit\Framework\TestCase;

class AcceptEncodingTest extends TestCase
{
    public function testInterface()
    {
        $h = new AcceptEncoding(
            $v = new AcceptEncodingValue('compress', new Quality(1))
        );

        $this->assertInstanceOf(Header::class, $h);
        $this->assertSame('Accept-Encoding', $h->name());
        $this->assertTrue($h->values()->contains($v));
        $this->assertSame('Accept-Encoding : compress;q=1', (string) $h);
    }

    public function testWithoutValues()
    {
        $this->assertSame('Accept-Encoding : ', (string) new AcceptEncoding);
    }
}

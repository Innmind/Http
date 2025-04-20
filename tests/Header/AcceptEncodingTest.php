<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\{
    Header\AcceptEncoding,
    Header,
    Header\AcceptEncodingValue,
    Header\Parameter\Quality
};
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class AcceptEncodingTest extends TestCase
{
    public function testInterface()
    {
        $h = new AcceptEncoding(
            $v = new AcceptEncodingValue('compress', new Quality(1)),
        );

        $this->assertInstanceOf(Header\Custom::class, $h);
        $this->assertSame('Accept-Encoding: compress;q=1', $h->normalize()->toString());
    }

    public function testWithoutValues()
    {
        $this->assertSame('Accept-Encoding: ', (new AcceptEncoding)->normalize()->toString());
    }
}

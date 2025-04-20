<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\{
    Header\AcceptCharset,
    Header,
    Header\AcceptCharsetValue,
    Header\Parameter\Quality
};
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class AcceptCharsetTest extends TestCase
{
    public function testInterface()
    {
        $h = new AcceptCharset(
            $v = new AcceptCharsetValue('unicode-1-1', new Quality(0.8)),
        );

        $this->assertInstanceOf(Header\Custom::class, $h);
        $this->assertSame('Accept-Charset: unicode-1-1;q=0.8', $h->normalize()->toString());
    }

    public function testWithoutValues()
    {
        $this->assertSame('Accept-Charset: ', (new AcceptCharset)->normalize()->toString());
    }
}

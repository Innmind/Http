<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http;

use Innmind\Http\{
    Headers,
    Header,
    Header\ContentType,
    Header\ContentTypeValue,
    Header\Parameter
};
use Innmind\Immutable\Map;
use PHPUnit\Framework\TestCase;

class HeadersTest extends TestCase
{
    public function testInterface()
    {
        $hs = new Headers(
            $ct = new ContentType(
                new ContentTypeValue(
                    'application',
                    'json',
                )
            )
        );

        $this->assertTrue($hs->contains('content-type'));
        $this->assertTrue($hs->contains('Content-Type'));
        $this->assertFalse($hs->contains('content_type'));
        $this->assertSame($ct, $hs->get('content-type'));
        $this->assertSame($ct, $hs->get('Content-Type'));
        $this->assertSame(1, $hs->count());
        $this->assertSame($ct, $hs->current());
        $this->assertSame('content-type', $hs->key());
        $this->assertTrue($hs->valid());
        $this->assertSame(null, $hs->next());
        $this->assertFalse($hs->valid());
        $this->assertSame(null, $hs->rewind());
        $this->assertTrue($hs->valid());
        $this->assertSame($ct, $hs->current());
    }

    public function testOf()
    {
        $headers = Headers::of(
            new ContentType(
                new ContentTypeValue(
                    'application',
                    'json',
                )
            )
        );

        $this->assertInstanceOf(Headers::class, $headers);
        $this->assertTrue($headers->contains('content-type'));
    }

    /**
     * @expectedException Innmind\Http\Exception\HeaderNotFound
     */
    public function testThrowWhenAccessingUnknownHeader()
    {
        (new Headers)->get('foo');
    }

    public function testAdd()
    {
        $headers1 = new Headers;
        $headers2 = $headers1->add(ContentType::of('application', 'json'));
        $headers3 = $headers2->add($header = ContentType::of('application', 'json'));

        $this->assertNotSame($headers1, $headers2);
        $this->assertInstanceOf(Headers::class, $headers2);
        $this->assertFalse($headers1->contains('content-type'));
        $this->assertTrue($headers2->contains('content-type'));
        $this->assertSame($header, $headers3->get('content-type'));
    }
}

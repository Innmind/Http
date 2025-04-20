<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http;

use Innmind\Http\{
    Headers,
    Header,
    Header\Allow,
    Header\ContentType,
    Header\Value,
};
use Innmind\MediaType\MediaType;
use Innmind\Immutable\SideEffect;
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class HeadersTest extends TestCase
{
    public function testInterface()
    {
        $hs = Headers::of(
            $ct = ContentType::of(
                MediaType::of(
                    'application/json',
                ),
            ),
        );

        $this->assertTrue($hs->contains('content-type'));
        $this->assertTrue($hs->contains('Content-Type'));
        $this->assertFalse($hs->contains('content_type'));
        $this->assertEquals($ct->normalize(), $hs->get('content-type')->match(
            static fn($header) => $header,
            static fn() => null,
        ));
        $this->assertEquals($ct->normalize(), $hs->get('Content-Type')->match(
            static fn($header) => $header,
            static fn() => null,
        ));
        $this->assertSame(1, $hs->count());
    }

    public function testOf()
    {
        $headers = Headers::of(
            ContentType::of(
                MediaType::of(
                    'application/json',
                ),
            ),
        );

        $this->assertInstanceOf(Headers::class, $headers);
        $this->assertTrue($headers->contains('content-type'));
    }

    public function testReturnNothingWhenAccessingUnknownHeader()
    {
        $this->assertNull(Headers::of()->get('foo')->match(
            static fn($header) => $header,
            static fn() => null,
        ));
    }

    public function testAdd()
    {
        $headers1 = Headers::of();
        $headers2 = ($headers1)(ContentType::of(
            MediaType::of('application/json'),
        ));
        $headers3 = ($headers2)($header = ContentType::of(
            MediaType::of('application/json'),
        )->normalize());

        $this->assertNotSame($headers1, $headers2);
        $this->assertInstanceOf(Headers::class, $headers2);
        $this->assertFalse($headers1->contains('content-type'));
        $this->assertTrue($headers2->contains('content-type'));
        $this->assertSame($header, $headers3->get('content-type')->match(
            static fn($header) => $header,
            static fn() => null,
        ));
    }

    public function testForeach()
    {
        $headers = Headers::of(
            ContentType::of(
                MediaType::of('application/json'),
            ),
            Header::of('x-foo'),
        );

        $called = 0;
        $this->assertInstanceOf(
            SideEffect::class,
            $headers->foreach(static function($header) use (&$called) {
                ++$called;
            }),
        );
        $this->assertSame(2, $called);
    }

    public function testReduce()
    {
        $headers = Headers::of(
            ContentType::of(
                MediaType::of('application/json'),
            ),
            Header::of('x-foo'),
        );

        $reduced = $headers->reduce(
            [],
            static function($carry, $header) {
                $carry[] = $header->name();

                return $carry;
            },
        );

        $this->assertSame(['Content-Type', 'x-foo'], $reduced);
    }

    public function testFind()
    {
        $headers = Headers::of(
            ContentType::of(
                MediaType::of('application/json'),
            ),
            Header::of('Allow'),
        );

        $this->assertTrue($headers->find(ContentType::class)->match(
            static fn() => true,
            static fn() => false,
        ));
        $this->assertFalse($headers->find(Allow::class)->match(
            static fn() => true,
            static fn() => false,
        ));

        $headers = Headers::of(
            Header::of('Content-Type', new Value('application/json')),
        );

        $this->assertFalse($headers->find(ContentType::class)->match(
            static fn() => true,
            static fn() => false,
        ));
    }

    public function testFilter()
    {
        $headers = Headers::of(
            ContentType::of(
                MediaType::of('application/json'),
            ),
            Header::of('x-foo'),
        );

        $this->assertCount(
            0,
            $headers->filter(static fn() => false),
        );
        $this->assertCount(
            2,
            $headers->filter(static fn() => true),
        );
        $this->assertCount(
            1,
            $headers->filter(static fn($header) => $header->name() === 'Content-Type'),
        );
    }

    public function testAll()
    {
        $headers = Headers::of(
            $contentType = ContentType::of(
                MediaType::of('application/json'),
            ),
            $foo = Header::of('x-foo'),
        );

        $this->assertEquals(
            [$contentType->normalize(), $foo],
            $headers->all()->toList(),
        );
    }
}

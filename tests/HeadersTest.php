<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http;

use Innmind\Http\{
    Headers,
    Header as HeaderInterface,
    Header\Header,
    Header\Allow,
    Header\ContentType,
    Header\ContentTypeValue,
    Header\Parameter,
    Header\Value\Value,
};
use Innmind\Immutable\SideEffect;
use PHPUnit\Framework\TestCase;

class HeadersTest extends TestCase
{
    public function testInterface()
    {
        $hs = Headers::of(
            $ct = new ContentType(
                new ContentTypeValue(
                    'application',
                    'json',
                ),
            ),
        );

        $this->assertTrue($hs->contains('content-type'));
        $this->assertTrue($hs->contains('Content-Type'));
        $this->assertFalse($hs->contains('content_type'));
        $this->assertSame($ct, $hs->get('content-type')->match(
            static fn($header) => $header,
            static fn() => null,
        ));
        $this->assertSame($ct, $hs->get('Content-Type')->match(
            static fn($header) => $header,
            static fn() => null,
        ));
        $this->assertSame(1, $hs->count());
    }

    public function testOf()
    {
        $headers = Headers::of(
            new ContentType(
                new ContentTypeValue(
                    'application',
                    'json',
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
        $headers2 = ($headers1)(ContentType::of('application', 'json'));
        $headers3 = ($headers2)($header = ContentType::of('application', 'json'));

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
            ContentType::of('application', 'json'),
            new Header('x-foo'),
        );

        $called = 0;
        $this->assertInstanceOf(
            SideEffect::class,
            $headers->foreach(static function(HeaderInterface $header) use (&$called) {
                ++$called;
            }),
        );
        $this->assertSame(2, $called);
    }

    public function testReduce()
    {
        $headers = Headers::of(
            ContentType::of('application', 'json'),
            new Header('x-foo'),
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
            ContentType::of('application', 'json'),
            new Header('Allow'),
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
            new Header('Content-Type', new Value('application/json')),
        );

        $this->assertFalse($headers->find(ContentType::class)->match(
            static fn() => true,
            static fn() => false,
        ));
    }
}

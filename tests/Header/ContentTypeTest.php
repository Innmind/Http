<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\{
    Header\ContentType,
    Header,
    Header\ContentTypeValue,
    Header\Parameter
};
use Innmind\Immutable\Sequence;
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class ContentTypeTest extends TestCase
{
    public function testInterface()
    {
        $h = new ContentType(
            $ct = new ContentTypeValue(
                'text',
                'html',
                new Parameter\Parameter('charset', 'UTF-8'),
            ),
        );

        $this->assertInstanceOf(Header::class, $h);
        $this->assertSame('Content-Type', $h->name());
        $v = $h->values();
        $this->assertInstanceOf(Sequence::class, $v);
        $this->assertSame($ct, $v->find(static fn() => true)->match(
            static fn($first) => $first,
            static fn() => null,
        ));
        $this->assertSame('Content-Type: text/html;charset=UTF-8', $h->toString());
        $this->assertSame('text/html;charset=UTF-8', $h->content()->toString());
    }

    public function testOf()
    {
        $header = ContentType::of(
            'text',
            'html',
            new Parameter\Parameter('charset', 'UTF-8'),
        );

        $this->assertInstanceOf(ContentType::class, $header);
        $this->assertSame('Content-Type: text/html;charset=UTF-8', $header->toString());
    }
}

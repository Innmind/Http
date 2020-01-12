<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\{
    Header\ContentType,
    Header,
    Header\Value,
    Header\ContentTypeValue,
    Header\Parameter
};
use Innmind\Immutable\{
    Set,
    Map,
};
use function Innmind\Immutable\first;
use PHPUnit\Framework\TestCase;

class ContentTypeTest extends TestCase
{
    public function testInterface()
    {
        $h = new ContentType(
            $ct = new ContentTypeValue(
                'text',
                'html',
                new Parameter\Parameter('charset', 'UTF-8'),
            )
        );

        $this->assertInstanceOf(Header::class, $h);
        $this->assertSame('Content-Type', $h->name());
        $v = $h->values();
        $this->assertInstanceOf(Set::class, $v);
        $this->assertSame(Value::class, (string) $v->type());
        $this->assertSame($ct, first($v));
        $this->assertSame('Content-Type: text/html;charset=UTF-8', $h->toString());
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

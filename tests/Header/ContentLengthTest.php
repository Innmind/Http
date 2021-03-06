<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\{
    Header\ContentLength,
    Header,
    Header\Value,
    Header\ContentLengthValue
};
use Innmind\Immutable\Set;
use function Innmind\Immutable\first;
use PHPUnit\Framework\TestCase;

class ContentLengthTest extends TestCase
{
    public function testInterface()
    {
        $h = new ContentLength(
            $av = new ContentLengthValue(42)
        );

        $this->assertInstanceOf(Header::class, $h);
        $this->assertSame('Content-Length', $h->name());
        $v = $h->values();
        $this->assertInstanceOf(Set::class, $v);
        $this->assertSame(Value::class, (string) $v->type());
        $this->assertSame($av, first($v));
        $this->assertSame('Content-Length: 42', $h->toString());
    }

    public function testOf()
    {
        $header = ContentLength::of(42);

        $this->assertInstanceOf(ContentLength::class, $header);
        $this->assertSame('Content-Length: 42', $header->toString());
    }
}

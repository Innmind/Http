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
    SetInterface,
    Map
};
use PHPUnit\Framework\TestCase;

class ContentTypeTest extends TestCase
{
    public function testInterface()
    {
        $h = new ContentType(
            $ct = new ContentTypeValue(
                'text',
                'html',
                (new Map('string', Parameter::class))
                    ->put('charset', new Parameter\Parameter('charset', 'UTF-8'))
            )
        );

        $this->assertInstanceOf(Header::class, $h);
        $this->assertSame('Content-Type', $h->name());
        $v = $h->values();
        $this->assertInstanceOf(SetInterface::class, $v);
        $this->assertSame(Value::class, (string) $v->type());
        $this->assertSame($ct, $v->current());
        $this->assertSame('Content-Type : text/html;charset=UTF-8', (string) $h);
    }
}

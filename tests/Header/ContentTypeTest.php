<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\Header\{
    ContentType,
    HeaderInterface,
    HeaderValueInterface,
    ContentTypeValue,
    Parameter,
    ParameterInterface
};
use Innmind\Immutable\{
    SetInterface,
    Map
};

class ContentTypeTest extends \PHPUnit_Framework_TestCase
{
    public function testInterface()
    {
        $h = new ContentType(
            $ct = new ContentTypeValue(
                'text',
                'html',
                (new Map('string', ParameterInterface::class))
                    ->put('charset', new Parameter('charset', 'UTF-8'))
            )
        );

        $this->assertInstanceOf(HeaderInterface::class, $h);
        $this->assertSame('Content-Type', $h->name());
        $v = $h->values();
        $this->assertInstanceOf(SetInterface::class, $v);
        $this->assertSame(HeaderValueInterface::class, (string) $v->type());
        $this->assertSame($ct, $v->current());
        $this->assertSame('Content-Type : text/html;charset=UTF-8', (string) $h);
    }
}

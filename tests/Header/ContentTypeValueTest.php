<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\Header\{
    ContentTypeValue,
    HeaderValue,
    Parameter
};
use Innmind\Immutable\Map;
use PHPUnit\Framework\TestCase;

class ContentTypeValueTest extends TestCase
{
    public function testInterface()
    {
        $a = new ContentTypeValue(
            'text',
            'x-c',
            $ps = (new Map('string', Parameter::class))
                ->put('charset', new Parameter\Parameter('charset', 'UTF-8'))
        );

        $this->assertInstanceOf(HeaderValue::class, $a);
        $this->assertSame('text', $a->type());
        $this->assertSame('x-c', $a->subType());
        $this->assertSame($ps, $a->parameters());
        $this->assertSame('text/x-c;charset=UTF-8', (string) $a);

        new ContentTypeValue(
            'application',
            'octet-stream'
        );
        new ContentTypeValue(
            'application',
            'octet-stream',
            (new Map('string', Parameter::class))
                ->put('charset', new Parameter\Parameter('charset', 'UTF-8'))
                ->put('level', new Parameter\Parameter('level', '1'))
        );
    }

    /**
     * @expectedException Innmind\Http\Exception\InvalidArgumentException
     */
    public function testThrowWhenInvalidParameters()
    {
        new ContentTypeValue('text', 'html', new Map('string', 'string'));
    }

    /**
     * @dataProvider invalids
     * @expectedException Innmind\Http\Exception\InvalidArgumentException
     */
    public function testThrowWhenInvalidContentTypeValue($type, $sub)
    {
        new ContentTypeValue($type, $sub);
    }

    public function invalids(): array
    {
        return [
            ['*', '*'],
            ['*', 'octet-stream'],
            ['text', '*'],
            ['foo/bar', ''],
            ['foo', 'bar+suffix'],
            ['foo', 'bar, level=1'],
        ];
    }
}

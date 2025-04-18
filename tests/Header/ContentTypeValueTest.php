<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\{
    Header\ContentTypeValue,
    Header\Value,
    Header\Parameter,
    Exception\DomainException,
};
use Innmind\BlackBox\PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;

class ContentTypeValueTest extends TestCase
{
    public function testInterface()
    {
        $a = new ContentTypeValue(
            'text',
            'x-c',
            $p = new Parameter\Parameter('charset', 'UTF-8'),
        );

        $this->assertInstanceOf(Value::class, $a);
        $this->assertSame('text', $a->type());
        $this->assertSame('x-c', $a->subType());
        $this->assertSame($p, $a->parameters()->get('charset')->match(
            static fn($charset) => $charset,
            static fn() => null,
        ));
        $this->assertSame('text/x-c;charset=UTF-8', $a->toString());

        new ContentTypeValue(
            'application',
            'octet-stream',
        );
        new ContentTypeValue(
            'application',
            'octet-stream',
            new Parameter\Parameter('charset', 'UTF-8'),
            new Parameter\Parameter('level', '1'),
        );
    }

    #[DataProvider('invalids')]
    public function testThrowWhenInvalidContentTypeValue($type, $sub)
    {
        $this->expectException(DomainException::class);
        $this->expectExceptionMessage("$type/$sub");

        new ContentTypeValue($type, $sub);
    }

    public static function invalids(): array
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

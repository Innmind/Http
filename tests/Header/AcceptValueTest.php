<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\Header\{
    AcceptValue,
    HeaderValue,
    Parameter\Quality,
    Parameter
};
use Innmind\Immutable\Map;
use PHPUnit\Framework\TestCase;

class AcceptValueTest extends TestCase
{
    public function testInterface()
    {
        $a = new AcceptValue(
            'text',
            'x-c',
            $ps = (new Map('string', Parameter::class))
                ->put('q', new Quality(0.8))
        );

        $this->assertInstanceOf(HeaderValue::class, $a);
        $this->assertSame('text', $a->type());
        $this->assertSame('x-c', $a->subType());
        $this->assertSame($ps, $a->parameters());
        $this->assertSame('text/x-c;q=0.8', (string) $a);

        new AcceptValue(
            '*',
            '*'
        );
        new AcceptValue(
            'application',
            '*'
        );
        new AcceptValue(
            'application',
            'octet-stream'
        );
        new AcceptValue(
            'application',
            'octet-stream',
            (new Map('string', Parameter::class))
                ->put('q', new Quality(0.4))
                ->put('level', new Parameter\Parameter('level', '1'))
        );
    }

    /**
     * @expectedException TypeError
     * @expectedException Argument 3 must be of type MapInterface<string, Innmind\Http\Header\Parameter>
     */
    public function testThrowWhenInvalidParameters()
    {
        new AcceptValue('*', '*', new Map('string', 'string'));
    }

    /**
     * @dataProvider invalids
     * @expectedException Innmind\Http\Exception\DomainException
     */
    public function testThrowWhenInvalidAcceptValue($type, $sub)
    {
        new AcceptValue($type, $sub);
    }

    public function invalids(): array
    {
        return [
            ['*', 'octet-stream'],
            ['foo/bar', ''],
            ['foo', 'bar+suffix'],
            ['foo', 'bar, level=1'],
        ];
    }
}

<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\{
    Header\AcceptValue,
    Header\Value,
    Header\Parameter\Quality,
    Header\Parameter,
    Exception\DomainException,
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
            $q = new Quality(0.8)
        );

        $this->assertInstanceOf(Value::class, $a);
        $this->assertSame('text', $a->type());
        $this->assertSame('x-c', $a->subType());
        $this->assertSame($q, $a->parameters()->get('q'));
        $this->assertSame('text/x-c;q=0.8', $a->toString());

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
            new Quality(0.4),
            new Parameter\Parameter('level', '1'),
        );
    }

    /**
     * @dataProvider invalids
     */
    public function testThrowWhenInvalidAcceptValue($type, $sub)
    {
        $this->expectException(DomainException::class);
        $this->expectExceptionMessage("$type/$sub");

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

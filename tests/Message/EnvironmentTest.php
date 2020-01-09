<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Message;

use Innmind\Http\Message\{
    Environment,
};
use Innmind\Immutable\Map;
use PHPUnit\Framework\TestCase;

class EnvironmentTest extends TestCase
{
    public function testInterface()
    {
        $f = new Environment(
            (new Map('string', 'scalar'))
                ->put('foo', 42)
        );

        $this->assertTrue($f->contains('foo'));
        $this->assertFalse($f->contains('bar'));
        $this->assertSame(42, $f->get('foo'));
        $this->assertSame(1, $f->count());
        $this->assertSame(42, $f->current());
        $this->assertSame('foo', $f->key());
        $this->assertTrue($f->valid());
        $this->assertSame(null, $f->next());
        $this->assertFalse($f->valid());
        $this->assertSame(null, $f->rewind());
        $this->assertTrue($f->valid());
        $this->assertSame(42, $f->current());
    }

    /**
     * @expectedException Innmind\Http\Exception\EnvironmentVariableNotFound
     */
    public function testThrowWhenAccessingUnknownVariable()
    {
        (new Environment)->get('foo');
    }

    /**
     * @expectedException TypeError
     * @expectedExceptionMessage Argument 1 must be of type MapInterface<string, scalar>
     */
    public function testThrowWhenInvalidMap()
    {
        new Environment(new Map('string', 'string'));
    }
}

<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Message;

use Innmind\Http\Message\{
    Environment,
    EnvironmentInterface
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

        $this->assertInstanceOf(EnvironmentInterface::class, $f);
        $this->assertTrue($f->has('foo'));
        $this->assertFalse($f->has('bar'));
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
     * @expectedException Innmind\Http\Exception\EnvironmentVariableNotFoundException
     */
    public function testThrowWhenAccessingUnknownVariable()
    {
        (new Environment(
            new Map('string', 'scalar')
        ))
            ->get('foo');
    }

    /**
     * @expectedException Innmind\Http\Exception\InvalidArgumentException
     */
    public function testThrowWhenInvalidMap()
    {
        new Environment(new Map('string', 'string'));
    }
}

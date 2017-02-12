<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Message;

use Innmind\Http\Message\{
    Cookies,
    CookiesInterface
};
use Innmind\Immutable\Map;
use PHPUnit\Framework\TestCase;

class CookiesTest extends TestCase
{
    public function testInterface()
    {
        $f = new Cookies(
            (new Map('string', 'scalar'))
                ->put('foo', 42)
        );

        $this->assertInstanceOf(CookiesInterface::class, $f);
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
     * @expectedException Innmind\Http\Exception\CookieNotFoundException
     */
    public function testThrowWhenAccessingUnknownCookie()
    {
        (new Cookies(
            new Map('string', 'scalar')
        ))
            ->get('foo');
    }

    /**
     * @expectedException Innmind\Http\Exception\InvalidArgumentException
     */
    public function testThrowWhenInvalidMap()
    {
        new Cookies(new Map('string', 'string'));
    }
}

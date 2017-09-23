<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Message\Cookies;

use Innmind\Http\Message\{
    Cookies\Cookies,
    Cookies as CookiesInterface
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
     * @expectedException Innmind\Http\Exception\CookieNotFound
     */
    public function testThrowWhenAccessingUnknownCookie()
    {
        (new Cookies)->get('foo');
    }

    /**
     * @expectedException TypeError
     * @expectedExceptionMessage Argument 1 must be of type MapInterface<string, scalar>
     */
    public function testThrowWhenInvalidMap()
    {
        new Cookies(new Map('string', 'string'));
    }
}

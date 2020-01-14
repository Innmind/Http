<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\{
    Header\Location,
    Header,
    Header\Value,
    Header\LocationValue
};
use Innmind\Immutable\Set;
use function Innmind\Immutable\first;
use Innmind\Url\Url;
use PHPUnit\Framework\TestCase;

class LocationTest extends TestCase
{
    public function testInterface()
    {
        $h = new Location(
            $av = new LocationValue(Url::of('/foo/bar'))
        );

        $this->assertInstanceOf(Header::class, $h);
        $this->assertSame('Location', $h->name());
        $v = $h->values();
        $this->assertInstanceOf(Set::class, $v);
        $this->assertSame(Value::class, (string) $v->type());
        $this->assertSame($av, first($v));
        $this->assertSame('Location: /foo/bar', $h->toString());
    }

    public function testOf()
    {
        $header = Location::of(Url::of('/foo/bar'));

        $this->assertInstanceOf(Location::class, $header);
        $this->assertSame('Location: /foo/bar', $header->toString());
    }
}

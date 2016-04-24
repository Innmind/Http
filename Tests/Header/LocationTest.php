<?php
declare(strict_types = 1);

namespace Innmind\Http\Tests\Header;

use Innmind\Http\Header\{
    Location,
    HeaderInterface,
    HeaderValueInterface,
    LocationValue
};
use Innmind\Immutable\SetInterface;
use Innmind\Url\Url;

class LocationTest extends \PHPUnit_Framework_TestCase
{
    public function testInterface()
    {
        $h = new Location(
            $av = new LocationValue(Url::fromString('/foo/bar'))
        );

        $this->assertInstanceOf(HeaderInterface::class, $h);
        $this->assertSame('Location', $h->name());
        $v = $h->values();
        $this->assertInstanceOf(SetInterface::class, $v);
        $this->assertSame(HeaderValueInterface::class, (string) $v->type());
        $this->assertSame($av, $v->current());
        $this->assertSame('Location : /foo/bar', (string) $h);
    }
}
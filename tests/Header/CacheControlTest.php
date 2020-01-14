<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\{
    Header\CacheControl,
    Header,
    Header\CacheControlValue\PublicCache
};
use Innmind\Immutable\{
    Set,
    Map
};
use PHPUnit\Framework\TestCase;

class CacheControlTest extends TestCase
{
    public function testInterface()
    {
        $h = new CacheControl(
            $v = new PublicCache
        );

        $this->assertInstanceOf(Header::class, $h);
        $this->assertSame('Cache-Control', $h->name());
        $this->assertTrue($h->values()->contains($v));
        $this->assertSame('Cache-Control: public', $h->toString());
    }
}

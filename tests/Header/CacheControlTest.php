<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\{
    Header\CacheControl,
    Header\CacheControl\Directive,
    Header,
};
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class CacheControlTest extends TestCase
{
    public function testInterface()
    {
        $h = CacheControl::of(
            Directive::public,
        );

        $this->assertInstanceOf(Header\Custom::class, $h);
        $this->assertSame('Cache-Control: public', $h->normalize()->toString());
    }
}

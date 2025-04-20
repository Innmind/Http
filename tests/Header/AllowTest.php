<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\{
    Header\Allow,
    Header,
    Method,
};
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class AllowTest extends TestCase
{
    public function testInterface()
    {
        $h = Allow::of(
            Method::get,
        );

        $this->assertInstanceOf(Header\Custom::class, $h);
        $this->assertSame('Allow: GET', $h->normalize()->toString());
    }

    public function testWithoutValues()
    {
        $this->assertSame('Allow: ', Allow::of()->normalize()->toString());
    }
}

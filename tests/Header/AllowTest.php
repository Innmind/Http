<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\{
    Header\Allow,
    Header,
    Header\AllowValue
};
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class AllowTest extends TestCase
{
    public function testInterface()
    {
        $h = new Allow(
            $v = new AllowValue('GET'),
        );

        $this->assertInstanceOf(Header::class, $h);
        $this->assertSame('Allow', $h->name());
        $this->assertTrue($h->values()->contains($v));
        $this->assertSame('Allow: GET', $h->toString());
    }

    public function testWithoutValues()
    {
        $this->assertSame('Allow: ', (new Allow)->toString());
    }

    public function testOf()
    {
        $header = Allow::of('GET');

        $this->assertInstanceOf(Allow::class, $header);
        $this->assertSame('Allow', $header->name());
        $this->assertSame('Allow: GET', $header->toString());
    }
}

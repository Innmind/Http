<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\{
    Header\Allow,
    Header,
    Header\AllowValue
};
use Innmind\Immutable\Set;
use PHPUnit\Framework\TestCase;

class AllowTest extends TestCase
{
    public function testInterface()
    {
        $h = new Allow(
            $v = new AllowValue('GET')
        );

        $this->assertInstanceOf(Header::class, $h);
        $this->assertSame('Allow', $h->name());
        $this->assertTrue($h->values()->contains($v));
        $this->assertSame('Allow: GET', (string) $h);
    }

    public function testWithoutValues()
    {
        $this->assertSame('Allow: ', (string) new Allow);
    }
}

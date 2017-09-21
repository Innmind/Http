<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\{
    Header\Allow,
    Header,
    Header\HeaderValue,
    Header\AllowValue
};
use Innmind\Immutable\Set;
use PHPUnit\Framework\TestCase;

class AllowTest extends TestCase
{
    public function testInterface()
    {
        $h = new Allow(
            $v = (new Set(HeaderValue::class))
                ->add(new AllowValue('GET'))
        );

        $this->assertInstanceOf(Header::class, $h);
        $this->assertSame('Allow', $h->name());
        $this->assertSame($v, $h->values());
        $this->assertSame('Allow : GET', (string) $h);
    }

    public function testWithoutValues()
    {
        $this->assertSame('Allow : ', (string) new Allow);
    }

    /**
     * @expectedException Innmind\Http\Exception\InvalidArgumentException
     */
    public function testRangeThrowWhenBuildingWithoutAllowValue()
    {
        new Allow(
            (new Set(HeaderValue::class))
                ->add(new HeaderValue\HeaderValue('foo'))
        );
    }
}

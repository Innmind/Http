<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\{
    Header\CacheControl,
    Header,
    Header\Value,
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
            $v = (new Set(Value::class))
                ->add(new PublicCache)
        );

        $this->assertInstanceOf(Header::class, $h);
        $this->assertSame('Cache-Control', $h->name());
        $this->assertSame($v, $h->values());
        $this->assertSame('Cache-Control : public', (string) $h);
    }

    /**
     * @expectedException Innmind\Http\Exception\InvalidArgumentException
     */
    public function testThrowWhenBuildingWithoutCacheControlValues()
    {
        new CacheControl(
            (new Set(Value::class))
                ->add(new Value\Value('foo'))
        );
    }

    /**
     * @expectedException Innmind\Http\Exception\CacheControlHeaderMustContainAtLeastOneValue
     */
    public function testThrowIfNoValueGiven()
    {
        new CacheControl(new Set(Value::class));
    }
}

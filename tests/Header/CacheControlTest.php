<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\Header\{
    CacheControl,
    HeaderInterface,
    HeaderValueInterface,
    HeaderValue,
    CacheControlValue\PublicCache
};
use Innmind\Immutable\{
    Set,
    Map
};

class CacheControlTest extends \PHPUnit_Framework_TestCase
{
    public function testInterface()
    {
        $h = new CacheControl(
            $v = (new Set(HeaderValueInterface::class))
                ->add(new PublicCache)
        );

        $this->assertInstanceOf(HeaderInterface::class, $h);
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
            (new Set(HeaderValueInterface::class))
                ->add(new HeaderValue('foo'))
        );
    }

    /**
     * @expectedException Innmind\Http\Exception\CacheControlHeaderMustContainAtLeastOneValueException
     */
    public function testThrowIfNoValueGiven()
    {
        new CacheControl(new Set(HeaderValueInterface::class));
    }
}

<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\Header\{
    AcceptLanguage,
    HeaderInterface,
    HeaderValueInterface,
    HeaderValue,
    AcceptLanguageValue,
    Quality
};
use Innmind\Immutable\Set;
use PHPUnit\Framework\TestCase;

class AcceptLanguageTest extends TestCase
{
    public function testInterface()
    {
        $h = new AcceptLanguage(
            $v = (new Set(HeaderValueInterface::class))
                ->add(new AcceptLanguageValue('fr', new Quality(0.8)))
        );

        $this->assertInstanceOf(HeaderInterface::class, $h);
        $this->assertSame('Accept-Language', $h->name());
        $this->assertSame($v, $h->values());
        $this->assertSame('Accept-Language : fr;q=0.8', (string) $h);
    }

    public function testWithoutValues()
    {
        $this->assertSame('Accept-Language : ', (string) new AcceptLanguage);
    }

    /**
     * @expectedException Innmind\Http\Exception\InvalidArgumentException
     */
    public function testThrowWhenBuildingWithoutAcceptLanguageValues()
    {
        new AcceptLanguage(
            (new Set(HeaderValueInterface::class))
                ->add(new HeaderValue('foo'))
        );
    }
}

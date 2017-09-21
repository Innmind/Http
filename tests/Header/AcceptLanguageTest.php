<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\{
    Header\AcceptLanguage,
    Header,
    Header\HeaderValue,
    Header\AcceptLanguageValue,
    Header\Parameter\Quality
};
use Innmind\Immutable\Set;
use PHPUnit\Framework\TestCase;

class AcceptLanguageTest extends TestCase
{
    public function testInterface()
    {
        $h = new AcceptLanguage(
            $v = (new Set(HeaderValue::class))
                ->add(new AcceptLanguageValue('fr', new Quality(0.8)))
        );

        $this->assertInstanceOf(Header::class, $h);
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
            (new Set(HeaderValue::class))
                ->add(new HeaderValue\HeaderValue('foo'))
        );
    }
}

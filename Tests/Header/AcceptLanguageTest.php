<?php
declare(strict_types = 1);

namespace Innmind\Http\Tests\Header;

use Innmind\Http\Header\{
    AcceptLanguage,
    HeaderInterface,
    HeaderValueInterface,
    HeaderValue,
    AcceptLanguageValue
};
use Innmind\Immutable\Set;

class AcceptLanguageTest extends \PHPUnit_Framework_TestCase
{
    public function testInterface()
    {
        $h = new AcceptLanguage(
            $v = (new Set(HeaderValueInterface::class))
                ->add(new AcceptLanguageValue('fr;q=0.8'))
        );

        $this->assertInstanceOf(HeaderInterface::class, $h);
        $this->assertSame('Accept-Language', $h->name());
        $this->assertSame($v, $h->values());
        $this->assertSame('Accept-Language : fr;q=0.8', (string) $h);
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

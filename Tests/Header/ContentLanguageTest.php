<?php
declare(strict_types = 1);

namespace Innmind\Http\Tests\Header;

use Innmind\Http\Header\{
    ContentLanguage,
    HeaderInterface,
    HeaderValueInterface,
    HeaderValue,
    ContentLanguageValue
};
use Innmind\Immutable\Set;

class ContentLanguageTest extends \PHPUnit_Framework_TestCase
{
    public function testInterface()
    {
        $h = new ContentLanguage(
            $v = (new Set(HeaderValueInterface::class))
                ->add(new ContentLanguageValue('fr'))
        );

        $this->assertInstanceOf(HeaderInterface::class, $h);
        $this->assertSame('Content-Language', $h->name());
        $this->assertSame($v, $h->values());
        $this->assertSame('Content-Language : fr', (string) $h);
    }

    /**
     * @expectedException Innmind\Http\Exception\InvalidArgumentException
     */
    public function testThrowWhenBuildingWithoutContentLanguageValues()
    {
        new ContentLanguage(
            (new Set(HeaderValueInterface::class))
                ->add(new HeaderValue('foo'))
        );
    }
}

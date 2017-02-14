<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\Header\{
    ContentLanguage,
    HeaderInterface,
    HeaderValueInterface,
    HeaderValue,
    ContentLanguageValue
};
use Innmind\Immutable\Set;
use PHPUnit\Framework\TestCase;

class ContentLanguageTest extends TestCase
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

    public function testWithoutValues()
    {
        $this->assertSame('Content-Language : ', (string) new ContentLanguage);
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

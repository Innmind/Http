<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\HeaderFactoryInterface,
    Factory\Header\ContentLanguageFactory,
    Header\ContentLanguage
};
use Innmind\Immutable\Str;
use PHPUnit\Framework\TestCase;

class ContentLanguageFactoryTest extends TestCase
{
    public function testInterface()
    {
        $this->assertInstanceOf(
            HeaderFactoryInterface::class,
            new ContentLanguageFactory
        );
    }

    public function testMake()
    {
        $header = (new ContentLanguageFactory)->make(
            new Str('Content-Language'),
            new Str('fr-FR, fr-CA')
        );

        $this->assertInstanceOf(ContentLanguage::class, $header);
        $this->assertSame('Content-Language : fr-FR, fr-CA', (string) $header);
    }

    /**
     * @expectedException Innmind\Http\Exception\InvalidArgumentException
     */
    public function testThrowWhenNotExpectedHeader()
    {
        (new ContentLanguageFactory)->make(
            new Str('foo'),
            new Str('')
        );
    }
}

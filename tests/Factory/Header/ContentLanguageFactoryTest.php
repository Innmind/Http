<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\HeaderFactory,
    Factory\Header\ContentLanguageFactory,
    Header\ContentLanguage,
    Exception\DomainException,
};
use Innmind\Immutable\Str;
use PHPUnit\Framework\TestCase;

class ContentLanguageFactoryTest extends TestCase
{
    public function testInterface()
    {
        $this->assertInstanceOf(
            HeaderFactory::class,
            new ContentLanguageFactory
        );
    }

    public function testMake()
    {
        $header = (new ContentLanguageFactory)(
            Str::of('Content-Language'),
            Str::of('fr-FR, fr-CA'),
        );

        $this->assertInstanceOf(ContentLanguage::class, $header);
        $this->assertSame('Content-Language: fr-FR, fr-CA', $header->toString());
    }

    public function testThrowWhenNotExpectedHeader()
    {
        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('foo');

        (new ContentLanguageFactory)(
            Str::of('foo'),
            Str::of(''),
        );
    }
}

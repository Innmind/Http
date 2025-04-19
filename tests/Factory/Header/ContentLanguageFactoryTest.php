<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\Header\ContentLanguageFactory,
    Header\ContentLanguage,
};
use Innmind\Immutable\Str;
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class ContentLanguageFactoryTest extends TestCase
{
    public function testMake()
    {
        $header = (new ContentLanguageFactory)(
            Str::of('Content-Language'),
            Str::of('fr-FR, fr-CA'),
        )->match(
            static fn($header) => $header,
            static fn() => null,
        );

        $this->assertInstanceOf(ContentLanguage::class, $header);
        $this->assertSame('Content-Language: fr-FR, fr-CA', $header->toString());
    }

    public function testReturnNothingWhenNotExpectedHeader()
    {
        $this->assertNull((new ContentLanguageFactory)(
            Str::of('foo'),
            Str::of(''),
        )->match(
            static fn($header) => $header,
            static fn() => null,
        ));
    }
}

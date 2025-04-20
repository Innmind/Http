<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\{
    Header\ContentLanguage,
    Header,
    Header\Content\Language,
};
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class ContentLanguageTest extends TestCase
{
    public function testInterface()
    {
        $h = Language::maybe('fr')
            ->map(ContentLanguage::of(...))
            ->match(
                static fn($header) => $header,
                static fn() => null,
            );

        $this->assertInstanceOf(Header\Custom::class, $h);
        $this->assertSame('Content-Language: fr', $h->normalize()->toString());
    }

    public function testWithoutValues()
    {
        $this->assertSame('Content-Language: ', ContentLanguage::of()->normalize()->toString());
    }
}

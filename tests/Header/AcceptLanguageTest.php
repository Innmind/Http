<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\{
    Header\AcceptLanguage,
    Header,
    Header\Accept\Language,
    Header\Parameter\Quality,
};
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class AcceptLanguageTest extends TestCase
{
    public function testInterface()
    {
        $h = Language::maybe('fr', new Quality(0.8))
            ->map(AcceptLanguage::of(...))
            ->match(
                static fn($header) => $header,
                static fn() => null,
            );

        $this->assertInstanceOf(Header\Custom::class, $h);
        $this->assertSame('Accept-Language: fr;q=0.8', $h->normalize()->toString());
    }

    public function testWithoutValues()
    {
        $this->assertSame('Accept-Language: ', AcceptLanguage::of()->normalize()->toString());
    }
}

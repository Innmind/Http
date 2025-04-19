<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\{
    Header\ContentLanguage,
    Header,
    Header\ContentLanguageValue
};
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class ContentLanguageTest extends TestCase
{
    public function testInterface()
    {
        $h = new ContentLanguage(
            $v = new ContentLanguageValue('fr'),
        );

        $this->assertInstanceOf(Header\Provider::class, $h);
        $this->assertSame('Content-Language: fr', $h->toHeader()->toString());
    }

    public function test()
    {
        $header = ContentLanguage::of('fr');

        $this->assertInstanceOf(ContentLanguage::class, $header);
        $this->assertSame('Content-Language: fr', $header->toHeader()->toString());
    }

    public function testWithoutValues()
    {
        $this->assertSame('Content-Language: ', (new ContentLanguage)->toHeader()->toString());
    }
}

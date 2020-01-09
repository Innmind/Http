<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\{
    Header\ContentLanguage,
    Header,
    Header\ContentLanguageValue
};
use Innmind\Immutable\Set;
use PHPUnit\Framework\TestCase;

class ContentLanguageTest extends TestCase
{
    public function testInterface()
    {
        $h = new ContentLanguage(
            $v = new ContentLanguageValue('fr')
        );

        $this->assertInstanceOf(Header::class, $h);
        $this->assertSame('Content-Language', $h->name());
        $this->assertTrue($h->values()->contains($v));
        $this->assertSame('Content-Language: fr', $h->toString());
    }

    public function test()
    {
        $header = ContentLanguage::of('fr');

        $this->assertInstanceOf(ContentLanguage::class, $header);
        $this->assertSame('Content-Language: fr', $header->toString());
    }

    public function testWithoutValues()
    {
        $this->assertSame('Content-Language: ', (new ContentLanguage)->toString());
    }
}

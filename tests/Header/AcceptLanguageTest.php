<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\{
    Header\AcceptLanguage,
    Header,
    Header\AcceptLanguageValue,
    Header\Parameter\Quality
};
use Innmind\Immutable\Set;
use PHPUnit\Framework\TestCase;

class AcceptLanguageTest extends TestCase
{
    public function testInterface()
    {
        $h = new AcceptLanguage(
            $v = new AcceptLanguageValue('fr', new Quality(0.8))
        );

        $this->assertInstanceOf(Header::class, $h);
        $this->assertSame('Accept-Language', $h->name());
        $this->assertTrue($h->values()->contains($v));
        $this->assertSame('Accept-Language: fr;q=0.8', $h->toString());
    }

    public function testWithoutValues()
    {
        $this->assertSame('Accept-Language: ', (new AcceptLanguage)->toString());
    }
}

<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\Header\Factory,
    Header\ContentLanguage,
};
use Innmind\TimeContinuum\Clock;
use Innmind\Immutable\Str;
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class ContentLanguageFactoryTest extends TestCase
{
    public function testMake()
    {
        $header = Factory::new(Clock::live())(
            Str::of('Content-Language'),
            Str::of('fr-FR, fr-CA'),
        );

        $this->assertInstanceOf(ContentLanguage::class, $header);
        $this->assertSame('Content-Language: fr-FR, fr-CA', $header->toString());
    }
}

<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\{
    Header\WWWAuthenticate,
    Header,
};
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class WWWAuthenticateTest extends TestCase
{
    public function testInterface()
    {
        $header = WWWAuthenticate\Challenge::maybe('Bearer', 'some value')
            ->map(WWWAuthenticate::of(...))
            ->match(
                static fn($header) => $header,
                static fn() => null,
            );

        $this->assertInstanceOf(Header\Custom::class, $header);
        $this->assertSame('WWW-Authenticate: Bearer realm="some value"', $header->normalize()->toString());
    }
}

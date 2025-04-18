<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\{
    Header\WWWAuthenticate,
    Header\WWWAuthenticateValue,
    Header
};
use Innmind\Immutable\Set;
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class WWWAuthenticateTest extends TestCase
{
    public function testInterface()
    {
        $header = new WWWAuthenticate(
            $value = new WWWAuthenticateValue('Bearer', 'some value'),
        );

        $this->assertInstanceOf(Header::class, $header);
        $this->assertInstanceOf(Set::class, $header->values());
        $this->assertCount(1, $header->values());
        $this->assertSame($value, $header->values()->find(static fn() => true)->match(
            static fn($first) => $first,
            static fn() => null,
        ));
        $this->assertSame('WWW-Authenticate: Bearer realm="some value"', $header->toString());
    }
}

<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\Header\WWWAuthenticate\Challenge;
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class WWWAuthenticateValueTest extends TestCase
{
    public function testInterface()
    {
        $value = Challenge::maybe('Basic', 'some value')->match(
            static fn($challenge) => $challenge,
            static fn() => null,
        );

        $this->assertInstanceOf(Challenge::class, $value);
        $this->assertSame('Basic', $value->scheme());
        $this->assertSame('some value', $value->realm());
        $this->assertSame('Basic realm="some value"', $value->toString());
    }

    public function testReturnNothingWhenInvalidSchemeFormat()
    {
        $this->assertNull(Challenge::maybe('Foo bar', 'some value')->match(
            static fn($challenge) => $challenge,
            static fn() => null,
        ));
    }
}

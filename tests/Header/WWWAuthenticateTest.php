<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\{
    Header\WWWAuthenticate,
    Header\WWWAuthenticateValue,
    Header
};
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class WWWAuthenticateTest extends TestCase
{
    public function testInterface()
    {
        $header = new WWWAuthenticate(
            $value = new WWWAuthenticateValue('Bearer', 'some value'),
        );

        $this->assertInstanceOf(Header\Custom::class, $header);
        $this->assertSame('WWW-Authenticate: Bearer realm="some value"', $header->normalize()->toString());
    }
}

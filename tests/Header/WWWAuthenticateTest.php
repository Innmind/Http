<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\{
    Header\WWWAuthenticate,
    Header\WWWAuthenticateValue,
    Header,
    Header\Value
};
use Innmind\Immutable\Set;
use function Innmind\Immutable\first;
use PHPUnit\Framework\TestCase;

class WWWAuthenticateTest extends TestCase
{
    public function testInterface()
    {
        $header = new WWWAuthenticate(
            $value = new WWWAuthenticateValue('Bearer', 'some value')
        );

        $this->assertInstanceOf(Header::class, $header);
        $this->assertInstanceOf(Set::class, $header->values());
        $this->assertSame(Value::class, (string) $header->values()->type());
        $this->assertCount(1, $header->values());
        $this->assertSame($value, first($header->values()));
        $this->assertSame('WWW-Authenticate: Bearer realm="some value"', $header->toString());
    }
}

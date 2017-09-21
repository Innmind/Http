<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\{
    Header\Authorization,
    Header,
    Header\HeaderValue,
    Header\AuthorizationValue
};
use Innmind\Immutable\SetInterface;
use PHPUnit\Framework\TestCase;

class AuthorizationTest extends TestCase
{
    public function testInterface()
    {
        $h = new Authorization(
            $av = new AuthorizationValue('Basic', '')
        );

        $this->assertInstanceOf(Header::class, $h);
        $this->assertSame('Authorization', $h->name());
        $v = $h->values();
        $this->assertInstanceOf(SetInterface::class, $v);
        $this->assertSame(HeaderValue::class, (string) $v->type());
        $this->assertSame($av, $v->current());
        $this->assertSame('Authorization : "Basic"', (string) $h);
    }
}

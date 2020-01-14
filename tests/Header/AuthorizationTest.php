<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\{
    Header\Authorization,
    Header,
    Header\Value,
    Header\AuthorizationValue
};
use Innmind\Immutable\Set;
use function Innmind\Immutable\first;
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
        $this->assertInstanceOf(Set::class, $v);
        $this->assertSame(Value::class, (string) $v->type());
        $this->assertSame($av, first($v));
        $this->assertSame('Authorization: "Basic"', $h->toString());
    }

    public function testOf()
    {
        $header = Authorization::of('Basic', 'foo');

        $this->assertInstanceOf(Authorization::class, $header);
        $this->assertSame('Authorization: "Basic" foo', $header->toString());
    }
}

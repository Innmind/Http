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
use PHPUnit\Framework\TestCase;

class AuthorizationTest extends TestCase
{
    public function testInterface()
    {
        $h = new Authorization(
            $av = new AuthorizationValue('Basic', ''),
        );

        $this->assertInstanceOf(Header::class, $h);
        $this->assertSame('Authorization', $h->name());
        $v = $h->values();
        $this->assertInstanceOf(Set::class, $v);
        $this->assertSame($av, $v->find(static fn() => true)->match(
            static fn($first) => $first,
            static fn() => null,
        ));
        $this->assertSame('Authorization: Basic', $h->toString());
    }

    public function testOf()
    {
        $header = Authorization::of('Basic', 'foo');

        $this->assertInstanceOf(Authorization::class, $header);
        $this->assertSame('Authorization: Basic foo', $header->toString());
        $this->assertSame('Basic', $header->scheme());
        $this->assertSame('foo', $header->parameter());
    }
}

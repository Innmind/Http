<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\Header\{
    Authorization,
    HeaderInterface,
    HeaderValueInterface,
    AuthorizationValue
};
use Innmind\Immutable\SetInterface;

class AuthorizationTest extends \PHPUnit_Framework_TestCase
{
    public function testInterface()
    {
        $h = new Authorization(
            $av = new AuthorizationValue('Basic', '')
        );

        $this->assertInstanceOf(HeaderInterface::class, $h);
        $this->assertSame('Authorization', $h->name());
        $v = $h->values();
        $this->assertInstanceOf(SetInterface::class, $v);
        $this->assertSame(HeaderValueInterface::class, (string) $v->type());
        $this->assertSame($av, $v->current());
        $this->assertSame('Authorization : "Basic"', (string) $h);
    }
}

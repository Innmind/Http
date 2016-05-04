<?php
declare(strict_types = 1);

namespace Innmind\Http\Tests\Factory\Header;

use Innmind\Http\{
    Factory\Header\AuthorizationFactory,
    Factory\HeaderFactoryInterface,
    Header\Authorization
};
use Innmind\Immutable\StringPrimitive as Str;

class AuthorizationFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testMake()
    {
        $f = new AuthorizationFactory;

        $this->assertInstanceOf(HeaderFactoryInterface::class, $f);

        $h = $f->make(
            new Str('Authorization'),
            new Str('Basic realm="WallyWorld"')
        );

        $this->assertInstanceOf(Authorization::class, $h);
        $this->assertSame(
            'Authorization : "Basic" realm="WallyWorld"',
            (string) $h
        );
    }
}

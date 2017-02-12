<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\Header\AuthorizationFactory,
    Factory\HeaderFactoryInterface,
    Header\Authorization
};
use Innmind\Immutable\StringPrimitive as Str;
use PHPUnit\Framework\TestCase;

class AuthorizationFactoryTest extends TestCase
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

    /**
     * @expectedException Innmind\Http\Exception\InvalidArgumentException
     */
    public function testThrowWhenNotExpectedHeader()
    {
        (new AuthorizationFactory)->make(
            new Str('foo'),
            new Str('')
        );
    }

    /**
     * @expectedException Innmind\Http\Exception\InvalidArgumentException
     */
    public function testThrowWhenNotValid()
    {
        (new AuthorizationFactory)->make(
            new Str('Authorization'),
            new Str('@')
        );
    }
}

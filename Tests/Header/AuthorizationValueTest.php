<?php
declare(strict_types = 1);

namespace Innmind\Http\Tests\Header;

use Innmind\Http\Header\{
    AuthorizationValue,
    HeaderValueInterface,
    Authorization\Credentials
};

class AuthorizationValueTest extends \PHPUnit_Framework_TestCase
{
    public function testInterface()
    {
        $a = new AuthorizationValue('"Basic" realm');

        $this->assertInstanceOf(HeaderValueInterface::class, $a);
        $this->assertSame('"Basic" realm', (string) $a);

        new AuthorizationValue('Basic');
        new AuthorizationValue('Basic realm');
        new AuthorizationValue('Foo');
    }

    public function testCredentials()
    {
        $p = (new AuthorizationValue('"Basic" realm'))->credentials();
        $this->assertInstanceOf(Credentials::class, $p);
        $this->assertSame('Basic', $p->scheme());
        $this->assertSame('realm', $p->parameter());
    }

    /**
     * @dataProvider invalids
     * @expectedException Innmind\Http\Exception\InvalidArgumentException
     */
    public function testThrowWhenInvalidAuthorizationValue($value)
    {
        new AuthorizationValue($value);
    }

    public function invalids(): array
    {
        return [
            ['foo@bar'],
            ['foo/bar'],
            ['"Basic"realm'],
        ];
    }
}

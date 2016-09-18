<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\Header\{
    AuthorizationValue,
    HeaderValueInterface,
    Authorization\Credentials
};

class AuthorizationValueTest extends \PHPUnit_Framework_TestCase
{
    public function testInterface()
    {
        $a = new AuthorizationValue('Basic', 'realm');

        $this->assertInstanceOf(HeaderValueInterface::class, $a);
        $this->assertSame('Basic', $a->scheme());
        $this->assertSame('realm', $a->parameter());
        $this->assertSame('"Basic" realm', (string) $a);

        new AuthorizationValue('Basic', '');
        new AuthorizationValue('Basic', 'realm="some value"');
        new AuthorizationValue('Foo', '');
    }

    /**
     * @dataProvider invalids
     * @expectedException Innmind\Http\Exception\InvalidArgumentException
     */
    public function testThrowWhenInvalidAuthorizationValue($value)
    {
        new AuthorizationValue($value, '');
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

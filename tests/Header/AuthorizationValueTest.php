<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\{
    Header\AuthorizationValue,
    Header\Value,
    Exception\DomainException,
};
use PHPUnit\Framework\TestCase;

class AuthorizationValueTest extends TestCase
{
    public function testInterface()
    {
        $a = new AuthorizationValue('Basic', 'realm');

        $this->assertInstanceOf(Value::class, $a);
        $this->assertSame('Basic', $a->scheme());
        $this->assertSame('realm', $a->parameter());
        $this->assertSame('Basic realm', $a->toString());

        new AuthorizationValue('Basic', '');
        new AuthorizationValue('Basic', 'realm="some value"');
        new AuthorizationValue('Foo', '');
    }

    /**
     * @dataProvider invalids
     */
    public function testThrowWhenInvalidAuthorizationValue($value)
    {
        $this->expectException(DomainException::class);
        $this->expectExceptionMessage($value);

        new AuthorizationValue($value, '');
    }

    public static function invalids(): array
    {
        return [
            ['foo@bar'],
            ['foo/bar'],
            ['"Basic"realm'],
            ['"Basic" realm'],
        ];
    }
}

<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\{
    Header\Authorization,
    Header,
};
use Innmind\BlackBox\PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;

class AuthorizationTest extends TestCase
{
    public function testOf()
    {
        $header = Authorization::of('Basic', 'foo');

        $this->assertInstanceOf(Authorization::class, $header);
        $this->assertInstanceOf(Header\Provider::class, $header);
        $this->assertSame('Authorization: Basic foo', $header->toHeader()->toString());
        $this->assertSame('Basic', $header->scheme());
        $this->assertSame('foo', $header->parameter());
    }

    public function testValids()
    {
        $this->assertInstanceOf(
            Authorization::class,
            Authorization::of('Basic', 'realm'),
        );
        $this->assertInstanceOf(
            Authorization::class,
            Authorization::of('Basic', ''),
        );
        $this->assertInstanceOf(
            Authorization::class,
            Authorization::of('Basic', 'realm="some value"'),
        );
        $this->assertInstanceOf(
            Authorization::class,
            Authorization::of('Foo', ''),
        );
    }

    #[DataProvider('invalids')]
    public function testReturnNothingWhenInvalidAuthorizationValue($value)
    {
        $this->assertNull(Authorization::maybe($value, '')->match(
            static fn($header) => $header,
            static fn() => null,
        ));
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

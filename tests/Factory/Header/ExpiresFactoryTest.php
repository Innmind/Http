<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\Header\ExpiresFactory,
    Factory\HeaderFactoryInterface,
    Header\Expires
};
use Innmind\Immutable\StringPrimitive as Str;

class ExpiresFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testInterface()
    {
        $this->assertInstanceOf(
            HeaderFactoryInterface::class,
            new ExpiresFactory
        );
    }

    public function testMake()
    {
        $header = (new ExpiresFactory)->make(
            new Str('Expires'),
            new Str('Tue, 15 Nov 1994 08:12:31 GMT')
        );

        $this->assertInstanceOf(Expires::class, $header);
        $this->assertSame(
            'Expires : Tue, 15 Nov 1994 08:12:31 +0000',
            (string) $header
        );
    }
}

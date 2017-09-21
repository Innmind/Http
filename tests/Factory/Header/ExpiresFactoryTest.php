<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\Header\ExpiresFactory,
    Factory\HeaderFactory,
    Header\Expires
};
use Innmind\Immutable\Str;
use PHPUnit\Framework\TestCase;

class ExpiresFactoryTest extends TestCase
{
    public function testInterface()
    {
        $this->assertInstanceOf(
            HeaderFactory::class,
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

    /**
     * @expectedException Innmind\Http\Exception\InvalidArgumentException
     */
    public function testThrowWhenNotExpectedHeader()
    {
        (new ExpiresFactory)->make(
            new Str('foo'),
            new Str('')
        );
    }
}

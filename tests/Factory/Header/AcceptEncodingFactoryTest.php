<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\Header\AcceptEncodingFactory,
    Factory\HeaderFactory,
    Header\AcceptEncoding
};
use Innmind\Immutable\Str;
use PHPUnit\Framework\TestCase;

class AcceptEncodingFactoryTest extends TestCase
{
    public function testMake()
    {
        $f = new AcceptEncodingFactory;

        $this->assertInstanceOf(HeaderFactory::class, $f);

        $h = $f->make(
            new Str('Accept-Encoding'),
            new Str('gzip, identity; q=0.5, *;q=0')
        );

        $this->assertInstanceOf(AcceptEncoding::class, $h);
        $this->assertSame(
            'Accept-Encoding : gzip;q=1, identity;q=0.5, *;q=0',
            (string) $h
        );
    }

    /**
     * @expectedException Innmind\Http\Exception\DomainException
     */
    public function testThrowWhenNotExpectedHeader()
    {
        (new AcceptEncodingFactory)->make(
            new Str('foo'),
            new Str('')
        );
    }

    /**
     * @expectedException Innmind\Http\Exception\DomainException
     */
    public function testThrowWhenNotValid()
    {
        (new AcceptEncodingFactory)->make(
            new Str('Accept-Encoding'),
            new Str('@')
        );
    }
}

<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\Header\AcceptFactory,
    Factory\HeaderFactory,
    Header\Accept
};
use Innmind\Immutable\Str;
use PHPUnit\Framework\TestCase;

class AcceptFactoryTest extends TestCase
{
    public function testMake()
    {
        $f = new AcceptFactory;

        $this->assertInstanceOf(HeaderFactory::class, $f);

        $h = ($f)(
            new Str('Accept'),
            new Str('audio/*; q=0.2; level="1", audio/basic')
        );

        $this->assertInstanceOf(Accept::class, $h);
        $this->assertSame('Accept: audio/*;q=0.2;level=1, audio/basic', $h->toString());
    }

    /**
     * @expectedException Innmind\Http\Exception\DomainException
     */
    public function testThrowWhenNotExpectedHeader()
    {
        (new AcceptFactory)(
            new Str('foo'),
            new Str('')
        );
    }

    /**
     * @expectedException Innmind\Http\Exception\DomainException
     */
    public function testThrowWhenNotValid()
    {
        (new AcceptFactory)(
            new Str('Accept'),
            new Str('@')
        );
    }
}

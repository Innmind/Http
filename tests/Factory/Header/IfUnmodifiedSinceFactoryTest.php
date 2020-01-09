<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\Header\IfUnmodifiedSinceFactory,
    Factory\HeaderFactory,
    Header\IfUnmodifiedSince
};
use Innmind\Immutable\Str;
use PHPUnit\Framework\TestCase;

class IfUnmodifiedSinceFactoryTest extends TestCase
{
    public function testMake()
    {
        $f = new IfUnmodifiedSinceFactory;

        $this->assertInstanceOf(HeaderFactory::class, $f);

        $h = $f->make(
            new Str('If-Unmodified-Since'),
            new Str('Tue, 15 Nov 1994 08:12:31 GMT')
        );

        $this->assertInstanceOf(IfUnmodifiedSince::class, $h);
        $this->assertSame(
            'If-Unmodified-Since: Tue, 15 Nov 1994 08:12:31 GMT',
            $h->toString(),
        );
    }

    /**
     * @expectedException Innmind\Http\Exception\DomainException
     */
    public function testThrowWhenNotExpectedHeader()
    {
        (new IfUnmodifiedSinceFactory)->make(
            new Str('foo'),
            new Str('')
        );
    }
}

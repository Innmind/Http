<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\Header\IfModifiedSinceFactory,
    Factory\HeaderFactory,
    Header\IfModifiedSince
};
use Innmind\Immutable\Str;
use PHPUnit\Framework\TestCase;

class IfModifiedSinceFactoryTest extends TestCase
{
    public function testMake()
    {
        $f = new IfModifiedSinceFactory;

        $this->assertInstanceOf(HeaderFactory::class, $f);

        $h = $f->make(
            new Str('If-Modified-Since'),
            new Str('Tue, 15 Nov 1994 08:12:31 GMT')
        );

        $this->assertInstanceOf(IfModifiedSince::class, $h);
        $this->assertSame(
            'If-Modified-Since: Tue, 15 Nov 1994 08:12:31 GMT',
            $h->toString(),
        );
    }

    /**
     * @expectedException Innmind\Http\Exception\DomainException
     */
    public function testThrowWhenNotExpectedHeader()
    {
        (new IfModifiedSinceFactory)->make(
            new Str('foo'),
            new Str('')
        );
    }
}

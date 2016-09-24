<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\HeaderFactoryInterface,
    Factory\Header\LinkFactory,
    Header\Link
};
use Innmind\Immutable\StringPrimitive as Str;

class LinkFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testInterface()
    {
        $this->assertInstanceOf(
            HeaderFactoryInterface::class,
            new LinkFactory
        );
    }

    public function testMake()
    {
        $header = (new LinkFactory)->make(
            new Str('Link'),
            new Str('</foo>; rel="next"; title=foo; bar="baz", </bar>')
        );

        $this->assertInstanceOf(Link::class, $header);
        $this->assertSame(
            'Link : </foo>; rel="next";title="foo";bar="baz", </bar>; rel="related"',
            (string) $header
        );
    }
}

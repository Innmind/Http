<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\HeaderFactory,
    Factory\Header\LinkFactory,
    Header\Link
};
use Innmind\Immutable\Str;
use PHPUnit\Framework\TestCase;

class LinkFactoryTest extends TestCase
{
    public function testInterface()
    {
        $this->assertInstanceOf(
            HeaderFactory::class,
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
            'Link : </foo>; rel="next";title=foo;bar=baz, </bar>; rel="related"',
            (string) $header
        );
    }

    public function testMakeWithComplexParameterValue()
    {
        $header = (new LinkFactory)->make(
            new Str('Link'),
            new Str('</foo>; rel="next"; title="!#$%&\'()*+-./0123456789:<=>?@abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMOPQRSTUVWXYZ[]^_`{|}~"')
        );

        $this->assertInstanceOf(Link::class, $header);
        $this->assertSame(
            'Link : </foo>; rel="next";title=!#$%&\'()*+-./0123456789:<=>?@abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMOPQRSTUVWXYZ[]^_`{|}~',
            (string) $header
        );
    }

    /**
     * @expectedException Innmind\Http\Exception\DomainException
     */
    public function testThrowWhenNotExpectedHeader()
    {
        (new LinkFactory)->make(
            new Str('foo'),
            new Str('')
        );
    }

    /**
     * @expectedException Innmind\Http\Exception\DomainException
     */
    public function testThrowWhenNotValid()
    {
        (new LinkFactory)->make(
            new Str('Link'),
            new Str('foo')
        );
    }
}

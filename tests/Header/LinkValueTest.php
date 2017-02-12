<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\Header\{
    LinkValue,
    HeaderValueInterface,
    Parameter,
    ParameterInterface
};
use Innmind\Url\Url;
use Innmind\Immutable\Map;
use PHPUnit\Framework\TestCase;

class LinkValueTest extends TestCase
{
    public function testInterface()
    {
        $l = new LinkValue(
            $url = Url::fromString('/some/resource'),
            'relationship',
            $ps = (new Map('string', ParameterInterface::class))
                ->put('title', new Parameter('title', 'Foo'))
        );

        $this->assertInstanceOf(HeaderValueInterface::class, $l);
        $this->assertSame($url, $l->url());
        $this->assertSame('relationship', $l->relationship());
        $this->assertSame($ps, $l->parameters());
        $this->assertSame(
            '</some/resource>; rel="relationship";title=Foo',
            (string) $l
        );
    }

    /**
     * @expectedException Innmind\Http\Exception\InvalidArgumentException
     */
    public function testThrowWhenInvalidParameters()
    {
        new LinkValue(Url::fromString('/foo'), 'rel', new Map('string', 'string'));
    }

    /**
     * @expectedException Innmind\Http\Exception\InvalidArgumentException
     */
    public function testThrowWhenInvalidLinkValue()
    {
        new LinkValue(
            Url::fromString('/foo'),
            '',
            new Map('string', ParameterInterface::class)
        );
    }
}

<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\Header\{
    Header,
    HeaderInterface,
    HeaderValueInterface,
    HeaderValue
};
use Innmind\Immutable\Set;
use PHPUnit\Framework\TestCase;

class HeaderTest extends TestCase
{
    public function testInterface()
    {
        $h = new Header(
            'Accept',
            $v = (new Set(HeaderValueInterface::class))
                ->add(new HeaderValue('application/json'))
                ->add(new HeaderValue('*/*'))
        );

        $this->assertInstanceOf(HeaderInterface::class, $h);
        $this->assertSame('Accept', $h->name());
        $this->assertSame($v, $h->values());
        $this->assertSame('Accept : application/json, */*', (string) $h);
    }

    public function testWithoutValues()
    {
        $this->assertSame('X-Foo : ', (string) new Header('X-Foo'));
    }

    /**
     * @expectedException Innmind\Http\Exception\InvalidArgumentException
     */
    public function testThrowWhenInvalidSetOfValues()
    {
        new Header('Accept', new Set('string'));
    }
}

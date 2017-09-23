<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\{
    Header,
    Header\HeaderValue
};
use Innmind\Immutable\Set;
use PHPUnit\Framework\TestCase;

class HeaderTest extends TestCase
{
    public function testInterface()
    {
        $h = new Header\Header(
            'Accept',
            $v = (new Set(HeaderValue::class))
                ->add(new HeaderValue\HeaderValue('application/json'))
                ->add(new HeaderValue\HeaderValue('*/*'))
        );

        $this->assertInstanceOf(Header::class, $h);
        $this->assertSame('Accept', $h->name());
        $this->assertSame($v, $h->values());
        $this->assertSame('Accept : application/json, */*', (string) $h);
    }

    public function testWithoutValues()
    {
        $this->assertSame('X-Foo : ', (string) new Header\Header('X-Foo'));
    }

    /**
     * @expectedException TypeError
     * @expectedExceptionMessage Argument 2 must be of type SetInterface<Innmind\Http\Header\HeaderValue>
     */
    public function testThrowWhenInvalidSetOfValues()
    {
        new Header\Header('Accept', new Set('string'));
    }
}

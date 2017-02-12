<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\Header\{
    AcceptEncoding,
    HeaderInterface,
    HeaderValueInterface,
    HeaderValue,
    AcceptEncodingValue,
    Quality
};
use Innmind\Immutable\Set;
use PHPUnit\Framework\TestCase;

class AcceptEncodingTest extends TestCase
{
    public function testInterface()
    {
        $h = new AcceptEncoding(
            $v = (new Set(HeaderValueInterface::class))
                ->add(new AcceptEncodingValue('compress', new Quality(1)))
        );

        $this->assertInstanceOf(HeaderInterface::class, $h);
        $this->assertSame('Accept-Encoding', $h->name());
        $this->assertSame($v, $h->values());
        $this->assertSame('Accept-Encoding : compress;q=1', (string) $h);
    }

    /**
     * @expectedException Innmind\Http\Exception\InvalidArgumentException
     */
    public function testThrowWhenBuildingWithoutAcceptEncodingValues()
    {
        new AcceptEncoding(
            (new Set(HeaderValueInterface::class))
                ->add(new HeaderValue('foo'))
        );
    }
}

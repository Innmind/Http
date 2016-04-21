<?php
declare(strict_types = 1);

namespace Innmind\Http\Tests\Header;

use Innmind\Http\Header\{
    AcceptEncoding,
    HeaderInterface,
    HeaderValueInterface,
    HeaderValue,
    AcceptEncodingValue
};
use Innmind\Immutable\Set;

class AcceptEncodingTest extends \PHPUnit_Framework_TestCase
{
    public function testInterface()
    {
        $h = new AcceptEncoding(
            $v = (new Set(HeaderValueInterface::class))
                ->add(new AcceptEncodingValue('compress'))
        );

        $this->assertInstanceOf(HeaderInterface::class, $h);
        $this->assertSame('Accept-Encoding', $h->name());
        $this->assertSame($v, $h->values());
        $this->assertSame('Accept-Encoding : compress', (string) $h);
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

<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\{
    Header\AcceptEncoding,
    Header,
    Header\HeaderValue,
    Header\AcceptEncodingValue,
    Header\Parameter\Quality
};
use Innmind\Immutable\Set;
use PHPUnit\Framework\TestCase;

class AcceptEncodingTest extends TestCase
{
    public function testInterface()
    {
        $h = new AcceptEncoding(
            $v = (new Set(HeaderValue::class))
                ->add(new AcceptEncodingValue('compress', new Quality(1)))
        );

        $this->assertInstanceOf(Header::class, $h);
        $this->assertSame('Accept-Encoding', $h->name());
        $this->assertSame($v, $h->values());
        $this->assertSame('Accept-Encoding : compress;q=1', (string) $h);
    }

    public function testWithoutValues()
    {
        $this->assertSame('Accept-Encoding : ', (string) new AcceptEncoding);
    }

    /**
     * @expectedException Innmind\Http\Exception\InvalidArgumentException
     */
    public function testThrowWhenBuildingWithoutAcceptEncodingValues()
    {
        new AcceptEncoding(
            (new Set(HeaderValue::class))
                ->add(new HeaderValue\HeaderValue('foo'))
        );
    }
}

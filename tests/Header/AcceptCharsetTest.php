<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\Header\{
    AcceptCharset,
    HeaderInterface,
    HeaderValueInterface,
    HeaderValue,
    AcceptCharsetValue,
    Quality
};
use Innmind\Immutable\Set;
use PHPUnit\Framework\TestCase;

class AcceptCharsetTest extends TestCase
{
    public function testInterface()
    {
        $h = new AcceptCharset(
            $v = (new Set(HeaderValueInterface::class))
                ->add(new AcceptCharsetValue('unicode-1-1', new Quality(0.8)))
        );

        $this->assertInstanceOf(HeaderInterface::class, $h);
        $this->assertSame('Accept-Charset', $h->name());
        $this->assertSame($v, $h->values());
        $this->assertSame('Accept-Charset : unicode-1-1;q=0.8', (string) $h);
    }

    public function testWithoutValues()
    {
        $this->assertSame('Accept-Charset : ', (string) new AcceptCharset);
    }

    /**
     * @expectedException Innmind\Http\Exception\InvalidArgumentException
     */
    public function testThrowWhenBuildingWithoutAcceptCharsetValues()
    {
        new AcceptCharset(
            (new Set(HeaderValueInterface::class))
                ->add(new HeaderValue('foo'))
        );
    }
}

<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\Header\HostFactory,
    Factory\HeaderFactory,
    Header\Host,
    Exception\DomainException,
};
use Innmind\Immutable\Str;
use PHPUnit\Framework\TestCase;

class HostFactoryTest extends TestCase
{
    /**
     * @dataProvider cases
     */
    public function testMake(string $host)
    {
        $f = new HostFactory;

        $this->assertInstanceOf(HeaderFactory::class, $f);

        $h = ($f)(
            Str::of('Host'),
            Str::of($host),
        );

        $this->assertInstanceOf(Host::class, $h);
        $this->assertSame(
            'Host: '.$host,
            $h->toString(),
        );
    }

    public function testThrowWhenNotExpectedHeader()
    {
        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('foo');

        (new HostFactory)(
            Str::of('foo'),
            Str::of(''),
        );
    }

    public function cases(): array
    {
        return [
            ['www.w3.org:8080'],
            ['www.w3.org'],
            ['localhost'],
            ['127.0.0.1'],
        ];
    }
}

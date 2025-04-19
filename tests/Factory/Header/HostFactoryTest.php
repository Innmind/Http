<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\Header\Factory,
    Header\Host,
};
use Innmind\TimeContinuum\Clock;
use Innmind\Immutable\Str;
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

use PHPUnit\Framework\Attributes\DataProvider;

class HostFactoryTest extends TestCase
{
    #[DataProvider('cases')]
    public function testMake(string $host)
    {
        $f = Factory::new(Clock::live());

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

    public static function cases(): array
    {
        return [
            ['www.w3.org:8080'],
            ['www.w3.org'],
            ['localhost'],
            ['127.0.0.1'],
        ];
    }
}

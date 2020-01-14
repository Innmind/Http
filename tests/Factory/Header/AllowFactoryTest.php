<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\HeaderFactory,
    Factory\Header\AllowFactory,
    Header\Allow,
    Exception\DomainException,
};
use Innmind\Immutable\Str;
use PHPUnit\Framework\TestCase;

class AllowFactoryTest extends TestCase
{
    public function testInterface()
    {
        $this->assertInstanceOf(
            HeaderFactory::class,
            new AllowFactory
        );
    }

    public function testMake()
    {
        $header = (new AllowFactory)(
            Str::of('Allow'),
            Str::of('get, post'),
        );

        $this->assertInstanceOf(Allow::class, $header);
        $this->assertSame('Allow: GET, POST', $header->toString());
    }

    public function testThrowWhenNotExpectedHeader()
    {
        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('foo');

        (new AllowFactory)(
            Str::of('foo'),
            Str::of(''),
        );
    }
}

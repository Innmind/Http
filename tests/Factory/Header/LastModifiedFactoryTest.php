<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\Header\LastModifiedFactory,
    Factory\HeaderFactory,
    Header\LastModified,
    Exception\DomainException,
};
use Innmind\TimeContinuum\Earth\Clock;
use Innmind\Immutable\Str;
use PHPUnit\Framework\TestCase;

class LastModifiedFactoryTest extends TestCase
{
    public function testInterface()
    {
        $this->assertInstanceOf(
            HeaderFactory::class,
            new LastModifiedFactory(new Clock),
        );
    }

    public function testMake()
    {
        $header = (new LastModifiedFactory(new Clock))(
            Str::of('Last-Modified'),
            Str::of('Tue, 15 Nov 1994 08:12:31 GMT'),
        );

        $this->assertInstanceOf(LastModified::class, $header);
        $this->assertSame(
            'Last-Modified: Tue, 15 Nov 1994 08:12:31 GMT',
            $header->toString(),
        );
    }

    public function testThrowWhenNotExpectedHeader()
    {
        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('foo');

        (new LastModifiedFactory(new Clock))(
            Str::of('foo'),
            Str::of(''),
        );
    }

    public function testThrowWhenNotOfExpectedFormat()
    {
        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('Last-Modified');

        (new LastModifiedFactory(new Clock))(
            Str::of('Last-Modified'),
            Str::of('2020-01-01'),
        );
    }
}

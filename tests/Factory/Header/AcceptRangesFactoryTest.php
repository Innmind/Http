<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\HeaderFactory,
    Factory\Header\AcceptRangesFactory,
    Header\AcceptRanges
};
use Innmind\Immutable\Str;
use PHPUnit\Framework\TestCase;

class AcceptRangesFactoryTest extends TestCase
{
    public function testInterface()
    {
        $this->assertInstanceOf(
            HeaderFactory::class,
            new AcceptRangesFactory
        );
    }

    public function testMake()
    {
        $header = (new AcceptRangesFactory)->make(
            new Str('Accept-Ranges'),
            new Str('bytes')
        );

        $this->assertInstanceOf(AcceptRanges::class, $header);
        $this->assertSame('Accept-Ranges: bytes', $header->toString());
    }

    /**
     * @expectedException Innmind\Http\Exception\DomainException
     */
    public function testThrowWhenNotExpectedHeader()
    {
        (new AcceptRangesFactory)->make(
            new Str('foo'),
            new Str('')
        );
    }
}

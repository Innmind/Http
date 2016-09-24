<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\HeaderFactoryInterface,
    Factory\Header\AcceptRangesFactory,
    Header\AcceptRanges
};
use Innmind\Immutable\StringPrimitive as Str;

class AcceptRangesFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testInterface()
    {
        $this->assertInstanceOf(
            HeaderFactoryInterface::class,
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
        $this->assertSame('Accept-Ranges : bytes', (string) $header);
    }
}

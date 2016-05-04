<?php
declare(strict_types = 1);

namespace Innmind\Http\Tests\Factory\Header;

use Innmind\Http\{
    Factory\Header\AcceptRangesFactory,
    Factory\HeaderFactoryInterface,
    Header\AcceptRanges
};
use Innmind\Immutable\StringPrimitive as Str;

class AcceptRangesFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testMake()
    {
        $f = new AcceptRangesFactory;

        $this->assertInstanceOf(HeaderFactoryInterface::class, $f);

        $h = $f->make(new Str('Accept-Ranges'), new Str('none'));

        $this->assertInstanceOf(AcceptRanges::class, $h);
        $this->assertSame('Accept-Ranges : none', (string) $h);
    }
}

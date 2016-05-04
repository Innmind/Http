<?php
declare(strict_types = 1);

namespace Innmind\Http\Tests\Factory\Header;

use Innmind\Http\{
    Factory\Header\AcceptFactory,
    Factory\HeaderFactoryInterface,
    Header\Accept
};
use Innmind\Immutable\StringPrimitive as Str;

class AcceptFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testMake()
    {
        $f = new AcceptFactory;

        $this->assertInstanceOf(HeaderFactoryInterface::class, $f);

        $h = $f->make(new Str('Accept'), new Str('audio/*; q=0.2, audio/basic'));

        $this->assertInstanceOf(Accept::class, $h);
        $this->assertSame('Accept : audio/*;q=0.2, audio/basic', (string) $h);
    }
}

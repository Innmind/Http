<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\Header\LastModifiedFactory,
    Factory\HeaderFactoryInterface,
    Header\LastModified
};
use Innmind\Immutable\StringPrimitive as Str;

class LastModifiedFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testInterface()
    {
        $this->assertInstanceOf(
            HeaderFactoryInterface::class,
            new LastModifiedFactory
        );
    }

    public function testMake()
    {
        $header = (new LastModifiedFactory)->make(
            new Str('Last-Modified'),
            new Str('Tue, 15 Nov 1994 08:12:31 GMT')
        );

        $this->assertInstanceOf(LastModified::class, $header);
        $this->assertSame(
            'Last-Modified : Tue, 15 Nov 1994 08:12:31 +0000',
            (string) $header
        );
    }

    /**
     * @expectedException Innmind\Http\Exception\InvalidArgumentException
     */
    public function testThrowWhenNotExpectedHeader()
    {
        (new LastModifiedFactory)->make(
            new Str('foo'),
            new Str('')
        );
    }
}

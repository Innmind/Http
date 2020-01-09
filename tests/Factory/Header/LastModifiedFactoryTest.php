<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\Header\LastModifiedFactory,
    Factory\HeaderFactory,
    Header\LastModified
};
use Innmind\Immutable\Str;
use PHPUnit\Framework\TestCase;

class LastModifiedFactoryTest extends TestCase
{
    public function testInterface()
    {
        $this->assertInstanceOf(
            HeaderFactory::class,
            new LastModifiedFactory
        );
    }

    public function testMake()
    {
        $header = (new LastModifiedFactory)(
            new Str('Last-Modified'),
            new Str('Tue, 15 Nov 1994 08:12:31 GMT')
        );

        $this->assertInstanceOf(LastModified::class, $header);
        $this->assertSame(
            'Last-Modified: Tue, 15 Nov 1994 08:12:31 GMT',
            $header->toString(),
        );
    }

    /**
     * @expectedException Innmind\Http\Exception\DomainException
     */
    public function testThrowWhenNotExpectedHeader()
    {
        (new LastModifiedFactory)(
            new Str('foo'),
            new Str('')
        );
    }
}

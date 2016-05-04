<?php
declare(strict_types = 1);

namespace Innmind\Http\Tests\Header;

use Innmind\Http\Header\{
    DateValue,
    HeaderValueInterface
};

class DateValueTest extends \PHPUnit_Framework_TestCase
{
    public function testInterface()
    {
        $h = new DateValue(new \DateTimeImmutable('2016-01-01 12:12:12+0200'));

        $this->assertInstanceOf(HeaderValueInterface::class, $h);
        $this->assertSame('Fri, 01 Jan 2016 12:12:12 +0200', (string) $h);
    }
}

<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\Header\{
    DateValue,
    HeaderValue
};
use PHPUnit\Framework\TestCase;

class DateValueTest extends TestCase
{
    public function testInterface()
    {
        $h = new DateValue(new \DateTimeImmutable('2016-01-01 12:12:12+0200'));

        $this->assertInstanceOf(HeaderValue::class, $h);
        $this->assertSame('Fri, 01 Jan 2016 12:12:12 +0200', (string) $h);
    }
}

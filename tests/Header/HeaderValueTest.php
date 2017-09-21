<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\Header\HeaderValue;
use PHPUnit\Framework\TestCase;

class HeaderValueTest extends TestCase
{
    public function testInterface()
    {
        $hv = new HeaderValue\HeaderValue('foo');

        $this->assertInstanceOf(HeaderValue::class, $hv);
        $this->assertSame('foo', (string) $hv);
    }
}

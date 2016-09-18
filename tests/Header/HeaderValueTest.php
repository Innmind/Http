<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\Header\{
    HeaderValue,
    HeaderValueInterface
};

class HeaderValueTest extends \PHPUnit_Framework_TestCase
{
    public function testInterface()
    {
        $hv = new HeaderValue('foo');

        $this->assertInstanceOf(HeaderValueInterface::class, $hv);
        $this->assertSame('foo', (string) $hv);
    }
}

<?php
declare(strict_types = 1);

namespace Innmind\Http\Tests\Header;

use Innmind\Http\Header\{
    ReferrerValue,
    HeaderValueInterface
};
use Innmind\Url\Url;

class ReferrerValueTest extends \PHPUnit_Framework_TestCase
{
    public function testInterface()
    {
        $a = new ReferrerValue(Url::fromString('/foo/bar'));

        $this->assertInstanceOf(HeaderValueInterface::class, $a);
        $this->assertSame('/foo/bar', (string) $a);
    }
}

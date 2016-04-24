<?php
declare(strict_types = 1);

namespace Innmind\Http\Tests\Header;

use Innmind\Http\Header\{
    ContentLocationValue,
    HeaderValueInterface
};
use Innmind\Url\Url;

class ContentLocationValueTest extends \PHPUnit_Framework_TestCase
{
    public function testInterface()
    {
        $a = new ContentLocationValue(Url::fromString('/foo/bar'));

        $this->assertInstanceOf(HeaderValueInterface::class, $a);
        $this->assertSame('/foo/bar', (string) $a);
    }
}

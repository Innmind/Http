<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header\CookieParameter;

use Innmind\Http\Header\{
    CookieParameter\Path,
    Parameter
};
use Innmind\Url\Path as UrlPath;
use PHPUnit\Framework\TestCase;

class PathTest extends TestCase
{
    public function testInterface()
    {
        $path = new Path(UrlPath::of('/foo'));

        $this->assertInstanceOf(Parameter::class, $path);
        $this->assertSame('Path=/foo', $path->toString());
    }
}

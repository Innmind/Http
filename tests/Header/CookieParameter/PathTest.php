<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header\CookieParameter;

use Innmind\Http\Header\SetCookie\Path;
use Innmind\Url\Path as UrlPath;
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class PathTest extends TestCase
{
    public function testInterface()
    {
        $path = Path::of(UrlPath::of('/foo'));

        $this->assertSame('Path=/foo', $path->toParameter()->toString());
    }
}

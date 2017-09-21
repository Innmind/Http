<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\Header\{
    ReferrerValue,
    HeaderValue
};
use Innmind\Url\Url;
use PHPUnit\Framework\TestCase;

class ReferrerValueTest extends TestCase
{
    public function testInterface()
    {
        $a = new ReferrerValue(Url::fromString('/foo/bar'));

        $this->assertInstanceOf(HeaderValue::class, $a);
        $this->assertSame('/foo/bar', (string) $a);
    }
}

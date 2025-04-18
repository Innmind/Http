<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\Header\{
    ReferrerValue,
    Value
};
use Innmind\Url\Url;
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class ReferrerValueTest extends TestCase
{
    public function testInterface()
    {
        $a = new ReferrerValue(Url::of('/foo/bar'));

        $this->assertInstanceOf(Value::class, $a);
        $this->assertSame('/foo/bar', $a->toString());
    }
}

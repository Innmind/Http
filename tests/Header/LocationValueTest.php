<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\Header\{
    LocationValue,
    Value
};
use Innmind\Url\Url;
use PHPUnit\Framework\TestCase;

class LocationValueTest extends TestCase
{
    public function testInterface()
    {
        $a = new LocationValue(Url::fromString('/foo/bar'));

        $this->assertInstanceOf(Value::class, $a);
        $this->assertSame('/foo/bar', $a->toString());
    }
}

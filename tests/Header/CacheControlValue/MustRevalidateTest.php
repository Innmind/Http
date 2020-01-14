<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header\CacheControlValue;

use Innmind\Http\Header\{
    CacheControlValue,
    CacheControlValue\MustRevalidate
};
use PHPUnit\Framework\TestCase;

class MustRevalidateTest extends TestCase
{
    public function testInterface()
    {
        $h = new MustRevalidate;

        $this->assertInstanceOf(CacheControlValue::class, $h);
        $this->assertSame('must-revalidate', $h->toString());
    }
}

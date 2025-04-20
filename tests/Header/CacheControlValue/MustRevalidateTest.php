<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header\CacheControlValue;

use Innmind\Http\Header\CacheControl\Directive;
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class MustRevalidateTest extends TestCase
{
    public function testInterface()
    {
        $this->assertSame('must-revalidate', Directive::mustRevalidate->toString());
    }
}

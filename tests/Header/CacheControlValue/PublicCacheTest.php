<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header\CacheControlValue;

use Innmind\Http\Header\CacheControl\Directive;
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class PublicCacheTest extends TestCase
{
    public function testInterface()
    {
        $this->assertSame('public', Directive::public->toString());
    }
}

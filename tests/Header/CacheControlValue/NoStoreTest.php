<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header\CacheControlValue;

use Innmind\Http\Header\CacheControl\Directive;
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class NoStoreTest extends TestCase
{
    public function testInterface()
    {
        $this->assertSame('no-store', Directive::noStore->toString());
    }
}

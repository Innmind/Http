<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Exception\Http;

use Innmind\Http\Exception\Http\{
    UnavailableForLegalReasons,
    Exception
};
use PHPUnit\Framework\TestCase;

class UnavailableForLegalReasonsTest extends TestCase
{
    public function testInterface()
    {
        $e = new UnavailableForLegalReasons;

        $this->assertInstanceOf(Exception::class, $e);
        $this->assertSame(451, $e->httpCode());
    }
}

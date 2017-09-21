<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Exception\Http;

use Innmind\Http\Exception\Http\{
    UnavailableForLegalReasonsException,
    Exception
};
use PHPUnit\Framework\TestCase;

class UnavailableForLegalReasonsExceptionTest extends TestCase
{
    public function testInterface()
    {
        $e = new UnavailableForLegalReasonsException;

        $this->assertInstanceOf(Exception::class, $e);
        $this->assertSame(451, $e->httpCode());
    }
}

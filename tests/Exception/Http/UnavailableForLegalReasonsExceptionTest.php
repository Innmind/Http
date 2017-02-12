<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Exception\Http;

use Innmind\Http\Exception\Http\{
    UnavailableForLegalReasonsException,
    ExceptionInterface
};
use PHPUnit\Framework\TestCase;

class UnavailableForLegalReasonsExceptionTest extends TestCase
{
    public function testInterface()
    {
        $e = new UnavailableForLegalReasonsException;

        $this->assertInstanceOf(ExceptionInterface::class, $e);
        $this->assertSame(451, $e->httpCode());
    }
}

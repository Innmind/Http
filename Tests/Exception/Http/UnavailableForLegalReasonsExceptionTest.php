<?php
declare(strict_types = 1);

namespace Innmind\Http\Tests\Exception\Http;

use Innmind\Http\Exception\Http\{
    UnavailableForLegalReasonsException,
    ExceptionInterface
};

class UnavailableForLegalReasonsExceptionTest extends \PHPUnit_Framework_TestCase
{
    public function testInterface()
    {
        $e = new UnavailableForLegalReasonsException;

        $this->assertInstanceOf(ExceptionInterface::class, $e);
        $this->assertSame(451, $e->httpCode());
    }
}

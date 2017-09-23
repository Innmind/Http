<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Exception\Http;

use Innmind\Http\Exception\Http\{
    MisdirectedRequest,
    Exception
};
use PHPUnit\Framework\TestCase;

class MisdirectedRequestTest extends TestCase
{
    public function testInterface()
    {
        $e = new MisdirectedRequest;

        $this->assertInstanceOf(Exception::class, $e);
        $this->assertSame(421, $e->httpCode());
    }
}

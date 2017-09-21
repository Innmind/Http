<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Exception\Http;

use Innmind\Http\Exception\Http\{
    InsufficientStorage,
    Exception
};
use PHPUnit\Framework\TestCase;

class InsufficientStorageTest extends TestCase
{
    public function testInterface()
    {
        $e = new InsufficientStorage;

        $this->assertInstanceOf(Exception::class, $e);
        $this->assertSame(507, $e->httpCode());
    }
}

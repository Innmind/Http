<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Exception\Http;

use Innmind\Http\Exception\Http\{
    UnprocessableEntity,
    Exception
};
use PHPUnit\Framework\TestCase;

class UnprocessableEntityTest extends TestCase
{
    public function testInterface()
    {
        $e = new UnprocessableEntity;

        $this->assertInstanceOf(Exception::class, $e);
        $this->assertSame(422, $e->httpCode());
    }
}

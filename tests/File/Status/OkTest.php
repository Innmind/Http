<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\File\Status;

use Innmind\Http\File\{
    Status,
    Status\Ok
};
use PHPUnit\Framework\TestCase;

class OkTest extends TestCase
{
    public function testInterface()
    {
        $s = new Ok;

        $this->assertInstanceOf(Status::class, $s);
        $this->assertSame(0, $s->value());
        $this->assertSame('UPLOAD_ERR_OK', $s->toString());
    }
}

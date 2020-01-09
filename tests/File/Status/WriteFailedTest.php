<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\File\Status;

use Innmind\Http\File\{
    Status,
    Status\WriteFailed
};
use PHPUnit\Framework\TestCase;

class WriteFailedTest extends TestCase
{
    public function testInterface()
    {
        $s = new WriteFailed;

        $this->assertInstanceOf(Status::class, $s);
        $this->assertSame(7, $s->value());
        $this->assertSame('UPLOAD_ERR_CANT_WRITE', $s->toString());
    }
}

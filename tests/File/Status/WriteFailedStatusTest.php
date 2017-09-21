<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\File\Status;

use Innmind\Http\File\{
    Status,
    Status\WriteFailedStatus
};
use PHPUnit\Framework\TestCase;

class WriteFailedStatusTest extends TestCase
{
    public function testInterface()
    {
        $s = new WriteFailedStatus;

        $this->assertInstanceOf(Status::class, $s);
        $this->assertSame(7, $s->value());
        $this->assertSame('UPLOAD_ERR_CANT_WRITE', (string) $s);
    }
}

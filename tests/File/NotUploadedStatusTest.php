<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\File;

use Innmind\Http\File\{
    StatusInterface,
    NotUploadedStatus
};
use PHPUnit\Framework\TestCase;

class NotUploadedStatusTest extends TestCase
{
    public function testInterface()
    {
        $s = new NotUploadedStatus;

        $this->assertInstanceOf(StatusInterface::class, $s);
        $this->assertSame(4, $s->value());
        $this->assertSame('UPLOAD_ERR_NO_FILE', (string) $s);
    }
}

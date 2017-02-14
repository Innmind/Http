<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\File;

use Innmind\Http\File\{
    StatusInterface,
    PartiallyUploadedStatus
};
use PHPUnit\Framework\TestCase;

class PartiallyUploadedStatusTest extends TestCase
{
    public function testInterface()
    {
        $s = new PartiallyUploadedStatus;

        $this->assertInstanceOf(StatusInterface::class, $s);
        $this->assertSame(3, $s->value());
        $this->assertSame('UPLOAD_ERR_PARTIAL', (string) $s);
    }
}

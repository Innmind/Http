<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\File\Status;

use Innmind\Http\File\{
    Status,
    Status\PartiallyUploaded
};
use PHPUnit\Framework\TestCase;

class PartiallyUploadedTest extends TestCase
{
    public function testInterface()
    {
        $s = new PartiallyUploaded;

        $this->assertInstanceOf(Status::class, $s);
        $this->assertSame(3, $s->value());
        $this->assertSame('UPLOAD_ERR_PARTIAL', $s->toString());
    }
}

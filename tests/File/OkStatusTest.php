<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\File;

use Innmind\Http\File\{
    StatusInterface,
    OkStatus
};
use PHPUnit\Framework\TestCase;

class OkStatusTest extends TestCase
{
    public function testInterface()
    {
        $s = new OkStatus;

        $this->assertInstanceOf(StatusInterface::class, $s);
        $this->assertSame(0, $s->value());
        $this->assertSame('UPLOAD_ERR_OK', (string) $s);
    }
}

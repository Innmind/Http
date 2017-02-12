<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\File;

use Innmind\Http\File\{
    StatusInterface,
    StoppedByExtensionStatus
};
use PHPUnit\Framework\TestCase;

class StoppedByExtensionStatusTest extends TestCase
{
    public function testInterface()
    {
        $s = new StoppedByExtensionStatus;

        $this->assertInstanceOf(StatusInterface::class, $s);
        $this->assertSame(8, $s->value());
        $this->assertSame('UPLOAD_ERR_EXTENSION', (string) $s);
    }
}

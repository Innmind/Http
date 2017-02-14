<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\File;

use Innmind\Http\File\{
    StatusInterface,
    NoTemporaryDirectoryStatus
};
use PHPUnit\Framework\TestCase;

class NoTemporaryDirectoryStatusTest extends TestCase
{
    public function testInterface()
    {
        $s = new NoTemporaryDirectoryStatus;

        $this->assertInstanceOf(StatusInterface::class, $s);
        $this->assertSame(6, $s->value());
        $this->assertSame('UPLOAD_ERR_NO_TMP_DIR', (string) $s);
    }
}

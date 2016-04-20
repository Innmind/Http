<?php
declare(strict_types = 1);

namespace Innmind\Http\Tests\File;

use Innmind\Http\File\{
    StatusInterface,
    NoTemporaryDirectoryStatus
};

class NoTemporaryDirectoryStatusTest extends \PHPUnit_Framework_TestCase
{
    public function testInterface()
    {
        $s = new NoTemporaryDirectoryStatus;

        $this->assertInstanceOf(StatusInterface::class, $s);
        $this->assertSame(6, $s->value());
        $this->assertSame('UPLOAD_ERR_NO_TMP_DIR', (string) $s);
    }
}

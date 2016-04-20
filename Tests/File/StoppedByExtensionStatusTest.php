<?php
declare(strict_types = 1);

namespace Innmind\Http\Tests\File;

use Innmind\Http\File\{
    StatusInterface,
    StoppedByExtensionStatus
};

class StoppedByExtensionStatusTest extends \PHPUnit_Framework_TestCase
{
    public function testInterface()
    {
        $s = new StoppedByExtensionStatus;

        $this->assertInstanceOf(StatusInterface::class, $s);
        $this->assertSame(8, $s->value());
        $this->assertSame('UPLOAD_ERR_EXTENSION', (string) $s);
    }
}

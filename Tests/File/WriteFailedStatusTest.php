<?php
declare(strict_types = 1);

namespace Innmind\Http\Tests\File;

use Innmind\Http\File\{
    StatusInterface,
    WriteFailedStatus
};

class WriteFailedStatusTest extends \PHPUnit_Framework_TestCase
{
    public function testInterface()
    {
        $s = new WriteFailedStatus;

        $this->assertInstanceOf(StatusInterface::class, $s);
        $this->assertSame(7, $s->value());
        $this->assertSame('UPLOAD_ERR_CANT_WRITE', (string) $s);
    }
}

<?php
declare(strict_types = 1);

namespace Innmind\Http\Tests\File;

use Innmind\Http\File\{
    StatusInterface,
    NotUploadedStatus
};

class NotUploadedStatusTest extends \PHPUnit_Framework_TestCase
{
    public function testInterface()
    {
        $s = new NotUploadedStatus;

        $this->assertInstanceOf(StatusInterface::class, $s);
        $this->assertSame(4, $s->value());
        $this->assertSame('UPLOAD_ERR_NO_FILE', (string) $s);
    }
}

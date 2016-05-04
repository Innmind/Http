<?php
declare(strict_types = 1);

namespace Innmind\Http\Tests\File;

use Innmind\Http\File\{
    StatusInterface,
    PartiallyUploadedStatus
};

class PartiallyUploadedStatusTest extends \PHPUnit_Framework_TestCase
{
    public function testInterface()
    {
        $s = new PartiallyUploadedStatus;

        $this->assertInstanceOf(StatusInterface::class, $s);
        $this->assertSame(3, $s->value());
        $this->assertSame('UPLOAD_ERR_PARTIAL', (string) $s);
    }
}

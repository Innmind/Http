<?php
declare(strict_types = 1);

namespace Innmind\Http\Tests\File;

use Innmind\Http\File\{
    StatusInterface,
    OkStatus
};

class OkStatusTest extends \PHPUnit_Framework_TestCase
{
    public function testInterface()
    {
        $s = new OkStatus;

        $this->assertInstanceOf(StatusInterface::class, $s);
        $this->assertSame(0, $s->value());
        $this->assertSame('UPLOAD_ERR_OK', (string) $s);
    }
}

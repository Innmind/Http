<?php
declare(strict_types = 1);

namespace Innmind\Http\Tests\File;

use Innmind\Http\File\{
    StatusInterface,
    ExceedsIniMaxFileSizeStatus
};

class ExceedsIniMaxFileSizeStatusTest extends \PHPUnit_Framework_TestCase
{
    public function testInterface()
    {
        $s = new ExceedsIniMaxFileSizeStatus;

        $this->assertInstanceOf(StatusInterface::class, $s);
        $this->assertSame(1, $s->value());
        $this->assertSame('UPLOAD_ERR_INI_SIZE', (string) $s);
    }
}

<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\File\Status;

use Innmind\Http\File\{
    Status,
    Status\ExceedsIniMaxFileSizeStatus
};
use PHPUnit\Framework\TestCase;

class ExceedsIniMaxFileSizeStatusTest extends TestCase
{
    public function testInterface()
    {
        $s = new ExceedsIniMaxFileSizeStatus;

        $this->assertInstanceOf(Status::class, $s);
        $this->assertSame(1, $s->value());
        $this->assertSame('UPLOAD_ERR_INI_SIZE', (string) $s);
    }
}

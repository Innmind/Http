<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\File\Status;

use Innmind\Http\File\{
    Status,
    Status\ExceedsFormMaxFileSize
};
use PHPUnit\Framework\TestCase;

class ExceedsFormMaxFileSizeTest extends TestCase
{
    public function testInterface()
    {
        $s = new ExceedsFormMaxFileSize;

        $this->assertInstanceOf(Status::class, $s);
        $this->assertSame(2, $s->value());
        $this->assertSame('UPLOAD_ERR_FORM_SIZE', $s->toString());
    }
}

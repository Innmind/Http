<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\File\Status;

use Innmind\Http\File\{
    Status,
    Status\StoppedByExtension
};
use PHPUnit\Framework\TestCase;

class StoppedByExtensionTest extends TestCase
{
    public function testInterface()
    {
        $s = new StoppedByExtension;

        $this->assertInstanceOf(Status::class, $s);
        $this->assertSame(8, $s->value());
        $this->assertSame('UPLOAD_ERR_EXTENSION', (string) $s);
    }
}

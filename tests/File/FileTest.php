<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\File;

use Innmind\Http\{
    File\File,
    File as FileInterface,
    File\Status\OkStatus
};
use Innmind\Filesystem\{
    NameInterface,
    StreamInterface,
    MediaType\NullMediaType
};
use PHPUnit\Framework\TestCase;

class FileTest extends TestCase
{
    public function testInterface()
    {
        $f = new File(
            'foo',
            $s = $this->createMock(StreamInterface::class),
            $ok = new OkStatus,
            $m = new NullMediaType
        );

        $this->assertInstanceOf(FileInterface::class, $f);
        $this->assertInstanceOf(NameInterface::class, $f->name());
        $this->assertSame('foo', (string) $f->name());
        $this->assertSame($s, $f->content());
        $this->assertSame($ok, $f->status());
        $this->assertSame($m, $f->clientMediaType());
    }
}

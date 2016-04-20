<?php
declare(strict_types = 1);

namespace Innmind\Http\Tests\File;

use Innmind\Http\File\{
    File,
    FileInterface,
    OkStatus
};
use Innmind\Filesystem\{
    NameInterface,
    StreamInterface,
    MediaType\NullMediaType
};

class FileTest extends \PHPUnit_Framework_TestCase
{
    public function testInterface()
    {
        $f = new File(
            'foo',
            $s = $this->getMock(StreamInterface::class),
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

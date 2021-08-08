<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\File;

use Innmind\Http\{
    File\File,
    File as FileInterface,
    File\Status\Ok
};
use Innmind\Filesystem\{
    Name,
    File\Content,
};
use Innmind\MediaType\MediaType;
use PHPUnit\Framework\TestCase;

class FileTest extends TestCase
{
    public function testInterface()
    {
        $f = new File(
            'foo',
            $s = $this->createMock(Content::class),
            'foo[bar]',
            $ok = new Ok,
            $m = MediaType::null(),
        );

        $this->assertInstanceOf(FileInterface::class, $f);
        $this->assertInstanceOf(Name::class, $f->name());
        $this->assertSame('foo', $f->name()->toString());
        $this->assertSame($s, $f->content());
        $this->assertSame($ok, $f->status());
        $this->assertSame('foo[bar]', $f->uploadKey());
    }
}

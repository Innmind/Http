<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Message;

use Innmind\Http\{
    Message\Files,
    File
};
use Innmind\Immutable\Map;
use PHPUnit\Framework\TestCase;

class FilesTest extends TestCase
{
    public function testInterface()
    {
        $f = $this->createMock(File::class);
        $f
            ->expects($this->once())
            ->method('uploadKey')
            ->willReturn('foo');
        $fs = new Files($f);

        $this->assertTrue($fs->contains('foo'));
        $this->assertFalse($fs->contains('bar'));
        $this->assertSame($f, $fs->get('foo'));
        $this->assertSame(1, $fs->count());
        $this->assertSame($f, $fs->current());
        $this->assertSame('foo', $fs->key());
        $this->assertTrue($fs->valid());
        $this->assertSame(null, $fs->next());
        $this->assertFalse($fs->valid());
        $this->assertSame(null, $fs->rewind());
        $this->assertTrue($fs->valid());
        $this->assertSame($f, $fs->current());
    }

    public function testOf()
    {
        $file = $this->createMock(File::class);
        $file
            ->expects($this->once())
            ->method('uploadKey')
            ->willReturn('foo');
        $files = Files::of($file);

        $this->assertInstanceOf(Files::class, $files);
        $this->assertTrue($files->contains('foo'));
    }

    /**
     * @expectedException Innmind\Http\Exception\FileNotFound
     */
    public function testThrowWhenAccessingUnknownFile()
    {
        (new Files)->get('foo');
    }
}

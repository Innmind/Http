<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Message;

use Innmind\Http\{
    Message\Files,
    File
};
use Innmind\Filesystem\Name\Name;
use Innmind\Immutable\Map;
use PHPUnit\Framework\TestCase;

class FilesTest extends TestCase
{
    public function testInterface()
    {
        $fs = new Files(
            (new Map('string', File::class))
                ->put(
                    'foo',
                    $f = $this->createMock(File::class)
                )
        );

        $this->assertTrue($fs->has('foo'));
        $this->assertFalse($fs->has('bar'));
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
            ->method('name')
            ->willReturn(new Name('foo'));
        $files = Files::of($file);

        $this->assertInstanceOf(Files::class, $files);
        $this->assertTrue($files->has('foo'));
    }

    /**
     * @expectedException Innmind\Http\Exception\FileNotFound
     */
    public function testThrowWhenAccessingUnknownFile()
    {
        (new Files)->get('foo');
    }

    /**
     * @expectedException TypeError
     * @expectedExceptionMessage Argument 1 must be of type MapInterface<string, Innmind\Http\File>
     */
    public function testThrowWhenInvalidMap()
    {
        new Files(new Map('string', 'string'));
    }
}

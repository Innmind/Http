<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Message;

use Innmind\Http\{
    Message\Files,
    File,
    Exception\FileNotFound,
};
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

    public function testThrowWhenAccessingUnknownFile()
    {
        $this->expectException(FileNotFound::class);
        $this->expectExceptionMessage('foo');

        (new Files)->get('foo');
    }

    public function testForeach()
    {
        $file = $this->createMock(File::class);
        $file
            ->expects($this->once())
            ->method('uploadKey')
            ->willReturn('foo');
        $files = new Files($file);

        $called = 0;
        $this->assertNull($files->foreach(static function() use (&$called) {
            ++$called;
        }));
        $this->assertSame(1, $called);
    }

    public function testReduce()
    {
        $file = $this->createMock(File::class);
        $file
            ->expects($this->any())
            ->method('uploadKey')
            ->willReturn('foo');
        $files = new Files($file);

        $reduced = $files->reduce(
            [],
            static function($carry, $file) {
                $carry[] = $file->uploadKey();

                return $carry;
            },
        );

        $this->assertSame(['foo'], $reduced);
    }
}

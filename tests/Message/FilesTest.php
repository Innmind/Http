<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Message;

use Innmind\Http\{
    Message\Files,
    Message\FilesInterface,
    File\File,
    File\FileInterface
};
use Innmind\Immutable\Map;

class FilesTest extends \PHPUnit_Framework_TestCase
{
    public function testInterface()
    {
        $fs = new Files(
            (new Map('string', FileInterface::class))
                ->put(
                    'foo',
                    $f = $this->createMock(FileInterface::class)
                )
        );

        $this->assertInstanceOf(FilesInterface::class, $fs);
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

    /**
     * @expectedException Innmind\Http\Exception\FileNotFoundException
     */
    public function testThrowWhenAccessingUnknownFile()
    {
        (new Files(
            new Map('string', FileInterface::class)
        ))
            ->get('foo');
    }

    /**
     * @expectedException Innmind\Http\Exception\InvalidArgumentException
     */
    public function testThrowWhenInvalidMap()
    {
        new Files(new Map('string', 'string'));
    }
}

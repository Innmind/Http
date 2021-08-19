<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Message;

use Innmind\Http\{
    Message\Files,
    File,
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

        $this->assertSame($f, $fs->get('foo')->match(
            static fn($foo) => $foo,
            static fn() => null,
        ));
    }

    public function testReturnNothingWhenAccessingUnknownFile()
    {
        $this->assertNull((new Files)->get('foo')->match(
            static fn($foo) => $foo,
            static fn() => null,
        ));
    }
}

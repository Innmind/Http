<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Message;

use Innmind\Http\Message\Files;
use Innmind\Filesystem\File;
use Innmind\Immutable\{
    Map,
    Either,
};
use PHPUnit\Framework\TestCase;

class FilesTest extends TestCase
{
    public function testInterface()
    {
        $f = $this->createMock(File::class);
        $fs = new Files(Map::of(['foo', Either::right($f)]));

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

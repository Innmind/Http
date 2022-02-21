<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Message;

use Innmind\Http\{
    Message\Files,
    File\Status,
};
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
        $file = $this->createMock(File::class);
        $files = Files::of([
            'foo' => Either::right($file),
        ]);

        $this->assertSame($file, $files->get('foo')->match(
            static fn($foo) => $foo,
            static fn() => null,
        ));
    }

    public function testReturnNothingWhenAccessingUnknownFile()
    {
        $this->assertSame(
            Status::notUploaded,
            Files::of([])->get('foo')->match(
                static fn() => null,
                static fn($status) => $status,
            ),
        );
    }

    public function testUnder()
    {
        $file = $this->createMock(File::class);
        $files = Files::of([
            'bar' => [
                'foo' => Either::right($file),
            ],
        ]);

        $this->assertSame(
            $file,
            $files->under('bar')->get('foo')->match(
                static fn($foo) => $foo,
                static fn() => null,
            ),
        );

        $this->assertSame(
            Status::notUploaded,
            $files->under('baz')->get('foo')->match(
                static fn() => null,
                static fn($status) => $status,
            ),
        );
    }

    public function testList()
    {
        $file1 = $this->createMock(File::class);
        $file2 = $this->createMock(File::class);
        $files = Files::of([
            'bar' => [
                Either::right($file1),
                Either::right(42),
                Either::left(Status::exceedsFormMaxFileSize),
                Either::left(42),
                Either::right($file2),
                24,
            ],
        ]);

        $this->assertSame(
            [$file1, $file2],
            $files->list('bar')->toList(),
        );
    }
}

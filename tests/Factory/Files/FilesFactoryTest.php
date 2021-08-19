<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Factory\Files;

use Innmind\Http\{
    Factory\Files\FilesFactory,
    Factory\FilesFactory as FilesFactoryInterface,
    Message\Files,
    File\Status\Ok
};
use Innmind\Immutable\{
    Map,
    MapInterface
};
use PHPUnit\Framework\TestCase;

class FilesFactoryTest extends TestCase
{
    public function testMake()
    {
        $f = new FilesFactory;

        $this->assertInstanceOf(FilesFactoryInterface::class, $f);

        $_FILES = [
            'file1' => [
                'name' => 'foo.txt',
                'type' => 'text/plain',
                'tmp_name' => '/tmp/foo.txt',
                'error' => \UPLOAD_ERR_OK,
                'size' => 3,
            ],
        ];
        \file_put_contents('/tmp/foo.txt', 'foo');
        $f = ($f)();

        $this->assertInstanceOf(Files::class, $f);
        $this->assertSame('foo.txt', $f->get('file1')->match(
            static fn($file) => $file->name()->toString(),
            static fn() => null,
        ));
        $this->assertSame('foo', $f->get('file1')->match(
            static fn($file) => $file->content()->toString(),
            static fn() => null,
        ));
        $this->assertSame('text/plain', $f->get('file1')->match(
            static fn($file) => $file->mediaType()->toString(),
            static fn() => null,
        ));
        $this->assertInstanceOf(Ok::class, $f->get('file1')->match(
            static fn($file) => $file->status(),
            static fn() => null,
        ));
        @\unlink('/tmp/foo.txt');
    }

    public function testMakeNested()
    {
        $f = new FilesFactory;

        $_FILES = [
            'download' => [
                'name' => [
                    'file1' => 'bar.txt',
                ],
                'type' => [
                    'file1' => 'text/plain',
                ],
                'tmp_name' => [
                    'file1' => '/tmp/bar.txt',
                ],
                'error' => [
                    'file1' => \UPLOAD_ERR_OK,
                ],
                'size' => [
                    'file1' => 3,
                ],
            ],
        ];
        \file_put_contents('/tmp/bar.txt', 'bar');
        $f = ($f)();

        $this->assertInstanceOf(Files::class, $f);
        $this->assertSame('bar.txt', $f->get('download.file1')->match(
            static fn($file) => $file->name()->toString(),
            static fn() => null,
        ));
        $this->assertSame('bar', $f->get('download.file1')->match(
            static fn($file) => $file->content()->toString(),
            static fn() => null,
        ));
        @\unlink('/tmp/bar.txt');
    }
}

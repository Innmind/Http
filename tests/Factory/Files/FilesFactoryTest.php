<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Factory\Files;

use Innmind\Http\{
    Factory\Files\FilesFactory,
    Factory\FilesFactory as FilesFactoryInterface,
    Message\Files,
    File\NotUploaded,
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
            'file2' => [
                'name' => 'bar.txt',
                'type' => 'text/plain',
                'tmp_name' => '/tmp/bar.txt',
                'error' => \UPLOAD_ERR_NO_FILE,
                'size' => 0,
            ],
        ];
        \file_put_contents('/tmp/foo.txt', 'foo');
        $f = ($f)();

        $this->assertInstanceOf(Files::class, $f);
        $this->assertSame('foo.txt', $f->get('file1')->match(
            static fn() => null,
            static fn($file) => $file->name()->toString(),
        ));
        $this->assertSame('foo', $f->get('file1')->match(
            static fn() => null,
            static fn($file) => $file->content()->toString(),
        ));
        $this->assertSame('text/plain', $f->get('file1')->match(
            static fn() => null,
            static fn($file) => $file->mediaType()->toString(),
        ));
        $this->assertInstanceOf(NotUploaded::class, $f->get('file2')->match(
            static fn($status) => $status,
            static fn() => null,
        ));
        @\unlink('/tmp/foo.txt');
    }
}

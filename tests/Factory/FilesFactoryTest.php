<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Factory;

use Innmind\Http\{
    Factory\FilesFactory,
    Factory\FilesFactoryInterface,
    Message\FilesInterface,
    File\OkStatus
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
                'error' => UPLOAD_ERR_OK,
                'size' => 3,
            ],
        ];
        file_put_contents('/tmp/foo.txt', 'foo');
        $f = $f->make();

        $this->assertInstanceOf(FilesInterface::class, $f);
        $this->assertSame(1, $f->count());
        $this->assertSame('foo.txt', (string) $f->get('file1')->name());
        $this->assertSame('foo', (string) $f->get('file1')->content());
        $this->assertSame('text/plain', (string) $f->get('file1')->clientMediaType());
        $this->assertInstanceOf(OkStatus::class, $f->get('file1')->status());
        @unlink('/tmp/foo.txt');
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
                    'file1' => UPLOAD_ERR_OK,
                ],
                'size' => [
                    'file1' => 3,
                ],
            ],
        ];
        file_put_contents('/tmp/bar.txt', 'bar');
        $f = $f->make();

        $this->assertInstanceOf(FilesInterface::class, $f);
        $this->assertSame(1, $f->count());
        $this->assertSame('bar.txt', (string) $f->get('download.file1')->name());
        $this->assertSame('bar', (string) $f->get('download.file1')->content());
        @unlink('/tmp/bar.txt');
    }
}

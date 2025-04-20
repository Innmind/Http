<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Factory\Files;

use Innmind\Http\{
    Factory\FilesFactory,
    ServerRequest\Files,
    File\Status,
};
use Innmind\IO\IO;
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class FilesFactoryTest extends TestCase
{
    public function testMake()
    {
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
            'list' => [
                'name' => ['list.txt'],
                'type' => ['text/plain'],
                'tmp_name' => ['/tmp/list.txt'],
                'error' => [\UPLOAD_ERR_OK],
                'size' => [3],
            ],
            'nested' => [
                'name' => [
                    'list' => ['nested.txt'],
                    'key' => 'key.txt',
                ],
                'type' => [
                    'list' => ['text/plain'],
                    'key' => 'text/plain',
                ],
                'tmp_name' => [
                    'list' => ['/tmp/nested.txt'],
                    'key' => '/tmp/nested.txt',
                ],
                'error' => [
                    'list' => [\UPLOAD_ERR_OK],
                    'key' => \UPLOAD_ERR_OK,
                ],
                'size' => [
                    'list' => [3],
                    'key' => 3,
                ],
            ],
        ];
        $factory = FilesFactory::native(
            IO::fromAmbientAuthority(),
        );

        \file_put_contents('/tmp/foo.txt', 'foo');
        $files = ($factory)();

        $this->assertInstanceOf(Files::class, $files);
        $this->assertSame('foo.txt', $files->get('file1')->match(
            static fn($file) => $file->name()->toString(),
            static fn() => null,
        ));
        $this->assertSame('foo', $files->get('file1')->match(
            static fn($file) => $file->content()->toString(),
            static fn() => null,
        ));
        $this->assertSame('text/plain', $files->get('file1')->match(
            static fn($file) => $file->mediaType()->toString(),
            static fn() => null,
        ));
        $this->assertSame(Status::notUploaded, $files->get('file2')->match(
            static fn() => null,
            static fn($status) => $status,
        ));
        $this->assertSame(
            ['list.txt'],
            $files
                ->list('list')
                ->map(static fn($file) => $file->name()->toString())
                ->toList(),
        );
        $this->assertSame(
            ['nested.txt'],
            $files
                ->under('nested')
                ->list('list')
                ->map(static fn($file) => $file->name()->toString())
                ->toList(),
        );
        $this->assertSame(
            'key.txt',
            $files
                ->under('nested')
                ->get('key')
                ->match(
                    static fn($file) => $file->name()->toString(),
                    static fn() => null,
                ),
        );
        $this->assertNull(
            $files
                ->under('nested')
                ->get('unknown')
                ->match(
                    static fn($file) => $file->name()->toString(),
                    static fn() => null,
                ),
        );
        @\unlink('/tmp/foo.txt');
    }
}

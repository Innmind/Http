<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Content;

use Innmind\Http\{
    Content\Multipart,
    Header\ContentType\Boundary,
};
use Innmind\Filesystem\{
    File\File,
    File\Content,
    File\Content\Chunkable,
};
use Innmind\Immutable\{
    Str,
    Sequence,
};
use Symfony\Component\Process\Process;
use PHPUnit\Framework\TestCase;
use Innmind\BlackBox\{
    PHPUnit\BlackBox,
    Set,
};
use Fixtures\Innmind\Filesystem\File as FFile;

class MultipartTest extends TestCase
{
    use BlackBox;

    public function testInterface()
    {
        $boundary = Boundary::uuid();

        $this->assertInstanceOf(Content::class, Multipart::boundary($boundary));
        $this->assertInstanceOf(Chunkable::class, Multipart::boundary($boundary));
    }

    public function testRender()
    {
        $content = Multipart::boundary($boundary = Boundary::uuid())
            ->with('foo', 'bar')
            ->withFile('baz', File::named(
                'baz.txt',
                Content\Chunks::of(Sequence::of(Str::of("foo\nbar\nbaz"))),
            ));
        $expected = <<<EXPECTED
        --{$boundary->value()}\r
        Content-Disposition: form-data; name="foo"\r
        \r
        bar\r
        --{$boundary->value()}\r
        Content-Disposition: form-data; name="baz"; filename="baz.txt"\r
        Content-Type: application/octet-stream\r
        Content-Length: 11\r
        \r
        foo
        bar
        baz\r
        --{$boundary->value()}--
        EXPECTED;

        $this->assertSame($expected, $content->toString());
        $this->assertSame(\mb_strlen($expected, 'ASCII'), $content->size()->match(
            static fn($size) => $size->toInt(),
            static fn() => null,
        ));
    }

    public function testLines()
    {
        $lines = Multipart::boundary($boundary = Boundary::uuid())
            ->with('foo', 'bar')
            ->withFile('baz', File::named(
                'baz.txt',
                Content\Chunks::of(Sequence::of(Str::of("foo\nbar\nbaz"))),
            ))
            ->lines()
            ->map(static fn($line) => $line->toString())
            ->toList();

        $this->assertSame(
            [
                "--{$boundary->value()}\r",
                "Content-Disposition: form-data; name=\"foo\"\r",
                "\r",
                "bar\r",
                "--{$boundary->value()}\r",
                "Content-Disposition: form-data; name=\"baz\"; filename=\"baz.txt\"\r",
                "Content-Type: application/octet-stream\r",
                "Content-Length: 11\r",
                "\r",
                'foo',
                'bar',
                "baz\r",
                "--{$boundary->value()}--",
            ],
            $lines,
        );
    }

    public function testEmptyBody()
    {
        $content = Multipart::boundary($boundary = Boundary::uuid());
        $expected = <<<EXPECTED
        --{$boundary->value()}\r
        --{$boundary->value()}--
        EXPECTED;

        $this->assertSame($expected, $content->toString());
        $this->assertSame(80, $content->size()->match(
            static fn($size) => $size->toInt(),
            static fn() => null,
        ));
    }

    public function testFunctional()
    {
        $process = new Process(['php', '-S', 'localhost:8080'], 'fixtures');
        $process->start();
        $process->waitUntil(static fn($_, $chunk) => \str_contains($chunk, 'Development Server'));

        $this
            ->forAll(
                Set\Strings::madeOf(Set\Chars::alphanumerical())->atLeast(1),
                Set\Unicode::strings(),
                Set\Strings::madeOf(Set\Chars::alphanumerical())->atLeast(1),
                FFile::any()->filter(static fn($file) => !\str_contains(
                    $file->name()->toString(),
                    '"',
                )),
            )
            ->then(function($varName, $varData, $fileName, $file) {
                $content = Multipart::boundary($boundary = Boundary::uuid())
                    ->with($varName, $varData)
                    ->withFile($fileName, $file);

                $in = \fopen('php://temp', 'w+');
                \fwrite($in, $content->toString());
                \fseek($in, 0);

                $handle = \curl_init('http://localhost:8080/');
                \curl_setopt($handle, \CURLOPT_HEADER, false);
                \curl_setopt($handle, \CURLOPT_RETURNTRANSFER, true);
                \curl_setopt($handle, \CURLOPT_HTTPHEADER, [
                    'Content-Type: multipart/form-data; '.$boundary->toString(),
                ]);
                \curl_setopt($handle, \CURLOPT_CUSTOMREQUEST, 'POST');
                \curl_setopt($handle, \CURLOPT_UPLOAD, true);
                \curl_setopt($handle, \CURLOPT_INFILE, $in);

                $response = \curl_exec($handle);

                $this->assertIsString($response);
                $parsed = \json_decode($response, true);
                $this->assertSame(
                    [
                        'post' => [
                            $varName => \mb_strlen($varData, 'ASCII'),
                        ],
                        'files' => [
                            $fileName => \mb_strlen($file->content()->toString(), 'ASCII'),
                        ],
                    ],
                    $parsed,
                );
            });

        $process->stop();
    }
}

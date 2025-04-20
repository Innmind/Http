<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Content;

use Innmind\Http\{
    Content\Multipart,
    Header\ContentType\Boundary,
};
use Innmind\Filesystem\{
    File,
    File\Content,
};
use Innmind\Immutable\{
    Str,
    Sequence,
};
use Symfony\Component\Process\Process;
use Innmind\BlackBox\{
    PHPUnit\BlackBox,
    PHPUnit\Framework\TestCase,
    Set,
};
use Fixtures\Innmind\Filesystem\File as FFile;

class MultipartTest extends TestCase
{
    use BlackBox;

    public function testRender()
    {
        $content = Multipart::boundary($boundary = Boundary::uuid())
            ->with('foo', 'bar')
            ->withFile('baz', File::named(
                'baz.txt',
                Content::ofChunks(Sequence::of(Str::of("foo\nbar\nbaz"))),
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

        $this->assertSame($expected, $content->asContent()->toString());
        $this->assertSame(\mb_strlen($expected, 'ASCII'), $content->asContent()->size()->match(
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
                Content::ofChunks(Sequence::of(Str::of("foo\nbar\nbaz"))),
            ))
            ->asContent()
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

        $this->assertSame($expected, $content->asContent()->toString());
        $this->assertSame(80, $content->asContent()->size()->match(
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
                \fwrite($in, $content->asContent()->toString());
                \fseek($in, 0);

                $handle = \curl_init('http://localhost:8080/');
                \curl_setopt($handle, \CURLOPT_HEADER, false);
                \curl_setopt($handle, \CURLOPT_RETURNTRANSFER, true);
                \curl_setopt($handle, \CURLOPT_HTTPHEADER, [
                    $boundary->toHeader()->normalize()->toString(),
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

<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\File;

use Innmind\Http\File\Input;
use Innmind\Filesystem\{
    File\Content\Lines,
    File\Content\Line,
    File\Content,
    Exception\FailedToLoadFile,
};
use Innmind\Url\Path;
use Innmind\Stream\Readable\Stream;
use Innmind\Immutable\{
    Str,
    Sequence,
    SideEffect,
};
use PHPUnit\Framework\TestCase;
use Innmind\BlackBox\{
    PHPUnit\BlackBox,
    Set,
};

class InputTest extends TestCase
{
    use BlackBox;

    public function testInterface()
    {
        $this->assertInstanceOf(Content::class, Input::of(Stream::open(Path::of('/dev/null'))));
    }

    public function testForeach()
    {
        $this
            ->forAll(Set\Sequence::of(
                $this->strings(),
            )->between(1, 10))
            ->then(function($lines) {
                \file_put_contents('/tmp/test_content', \implode("\n", $lines));
                $content = Input::of(Stream::open(Path::of('/tmp/test_content')));
                $called = 0;

                $this->assertInstanceOf(
                    SideEffect::class,
                    $content->foreach(function($line) use ($lines, &$called) {
                        $this->assertSame($lines[$called], $line->toString());
                        $called++;
                    }),
                );
                $this->assertSame(\count($lines), $called);
            });
    }

    public function testForeachCalledOnceWhenEmptyContent()
    {
        \file_put_contents('/tmp/test_content', '');
        $content = Input::of(Stream::open(Path::of('/tmp/test_content')));
        $called = 0;

        $this->assertInstanceOf(
            SideEffect::class,
            $content->foreach(function($line) use (&$called) {
                $this->assertSame('', $line->toString());
                $called++;
            }),
        );
        $this->assertSame(1, $called);
    }

    public function testMap()
    {
        $this
            ->forAll(
                Set\Sequence::of(
                    $this->strings(),
                )->between(1, 10),
                $this->strings(),
            )
            ->then(function($lines, $replacement) {
                $replacement = Line::of(Str::of($replacement));
                \file_put_contents('/tmp/test_content', \implode("\n", $lines));
                $content = Input::of(Stream::open(Path::of('/tmp/test_content')));
                $mapped = $content->map(static fn() => $replacement);
                $called = 0;

                $this->assertNotSame($content, $mapped);
                $this->assertInstanceOf(
                    SideEffect::class,
                    $mapped->foreach(function($line) use ($replacement, &$called) {
                        $this->assertSame($replacement, $line);
                        $called++;
                    }),
                );
                $this->assertSame(\count($lines), $called);
            });
    }

    public function testFlatMap()
    {
        $this
            ->forAll(
                Set\Sequence::of(
                    $this->strings(),
                )->between(1, 10),
                $this->strings(),
            )
            ->then(function($lines, $newLine) {
                $newLine = Line::of(Str::of($newLine));
                \file_put_contents('/tmp/test_content', \implode("\n", $lines));
                $content = Input::of(Stream::open(Path::of('/tmp/test_content')));
                $extra = $content->flatMap(static fn($line) => Lines::of(Sequence::of(
                    $line,
                    $newLine,
                )));

                $called = 0;
                $extra->foreach(static function() use (&$called) {
                    ++$called;
                });
                $this->assertSame(\count($lines) * 2, $called);
            });
    }

    public function testFilter()
    {
        $this
            ->forAll(Set\Sequence::of(
                $this->strings(),
            )->between(1, 10))
            ->then(function($lines) {
                \file_put_contents('/tmp/test_content', \implode("\n", $lines));
                $content = Input::of(Stream::open(Path::of('/tmp/test_content')));
                $shouldBeEmpty = $content->filter(static fn() => false);
                $shouldBeTheSame = $content->filter(static fn() => true);

                $called = 0;
                $shouldBeEmpty->foreach(static function() use (&$called) {
                    ++$called;
                });
                $this->assertSame(0, $called);
            });
    }

    public function testLines()
    {
        $this
            ->forAll(
                Set\Sequence::of(
                    $this->strings(),
                )->between(1, 10),
                $this->strings(),
            )
            ->then(function($lines, $replacement) {
                $replacement = Line::of(Str::of($replacement));
                \file_put_contents('/tmp/test_content', \implode("\n", $lines));
                $content = Input::of(Stream::open(Path::of('/tmp/test_content')));

                $called = 0;
                $sequence = $content->lines()->map(function($line) use ($lines, $replacement, &$called) {
                    $this->assertSame($lines[$called], $line->toString());
                    $called++;

                    return $replacement;
                });

                $this->assertInstanceOf(Sequence::class, $sequence);
                $size = 0;
                $sequence->foreach(function($line) use ($replacement, &$size) {
                    $this->assertSame($replacement, $line);
                    $size++;
                });
                // we don't call $sequence->size() as the sequence is lazy so it
                // would perform the transformation above twice resulting in an
                // error due to &$called being incremented above the number of
                // lines
                $this->assertSame(\count($lines), $size);
            });
    }

    public function testReduce()
    {
        $this
            ->forAll(Set\Sequence::of(
                $this->strings(),
            )->between(1, 10))
            ->then(function($lines) {
                \file_put_contents('/tmp/test_content', \implode("\n", $lines));
                $content = Input::of(Stream::open(Path::of('/tmp/test_content')));

                $this->assertSame(
                    \count($lines),
                    $content->reduce(
                        0,
                        static fn($carry, $_) => $carry + 1,
                    ),
                );
            });
    }

    public function testToString()
    {
        $this
            ->forAll(Set\Sequence::of(
                $this->strings(),
            )->between(1, 10))
            ->then(function($lines) {
                \file_put_contents('/tmp/test_content', \implode("\n", $lines));
                $content = Input::of(Stream::open(Path::of('/tmp/test_content')));

                $this->assertSame(\implode("\n", $lines), $content->toString());
            });
    }

    public function testSize()
    {
        $this
            ->forAll(Set\Sequence::of(
                $this->strings(),
            )->between(0, 10))
            ->then(function($lines) {
                $expectedSize = Str::of(\implode("\n", $lines))->toEncoding('ASCII')->length();
                \file_put_contents('/tmp/test_content', \implode("\n", $lines));
                $content = Input::of(Stream::open(Path::of('/tmp/test_content')));

                $this->assertSame(
                    $expectedSize,
                    $content->size()->match(
                        static fn($size) => $size->toInt(),
                        static fn() => null,
                    ),
                );
            });
    }

    public function testThrowWhenTryingToLoadInputTwice()
    {
        $this
            ->forAll(Set\Sequence::of(
                $this->strings(),
            )->between(1, 10))
            ->then(function($lines) {
                \file_put_contents('/tmp/test_content', \implode("\n", $lines));
                $content = Input::of(Stream::open(Path::of('/tmp/test_content')));

                $this->assertIsString($content->toString());

                try {
                    $content->toString();
                    $this->fail('it should throw');
                } catch (\Exception $e) {
                    $this->assertInstanceOf(FailedToLoadFile::class, $e);
                }
            });
    }

    private function strings(): Set
    {
        return Set\Decorate::immutable(
            static fn($line) => \rtrim($line, "\n"),
            Set\Unicode::strings(),
        )->filter(static fn($line) => !\str_contains($line, "\n"));
    }
}

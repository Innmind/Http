<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Stream;

use Innmind\Http\{
    Stream\ToPsr7,
    Exception\LogicException,
};
use Innmind\Stream\{
    Readable,
    Stream\Size,
    Stream\Position,
    Stream\Position\Mode,
    Exception\PositionNotSeekable
};
use Innmind\Immutable\{
    Str,
    Maybe,
};
use Psr\Http\Message\StreamInterface;
use PHPUnit\Framework\TestCase;
use Innmind\BlackBox\{
    PHPUnit\BlackBox,
    Set,
};

class ToPsr7Test extends TestCase
{
    use BlackBox;

    public function testInterface()
    {
        $this->assertInstanceOf(
            StreamInterface::class,
            new ToPsr7($this->createMock(Readable::class))
        );
    }

    public function testStringCast()
    {
        $this
            ->forAll(Set\Unicode::strings())
            ->then(function($content) {
                $stream = new ToPsr7(
                    $inner = $this->createMock(Readable::class)
                );
                $inner
                    ->expects($this->once())
                    ->method('toString')
                    ->willReturn($content);

                $this->assertSame($content, (string) $stream);
            });
    }

    public function testClose()
    {
        $stream = new ToPsr7(
            $inner = $this->createMock(Readable::class)
        );
        $inner
            ->expects($this->once())
            ->method('close');

        $this->assertNull($stream->close());
    }

    public function testDetachReturnNothingWhenTheUnderlyingResourceIsNotAccessible()
    {
        $stream = new ToPsr7(
            $this->createMock(Readable::class)
        );

        $this->assertNull($stream->detach());
    }

    public function testDetachReturnTheUnderlyingResource()
    {
        $stream = new ToPsr7(new Readable\Stream(
            $resource = \fopen('php://temp', 'r+')
        ));

        $this->assertSame($resource, $stream->detach());
    }

    public function testReturnTheSizeWhenKnown()
    {
        $this
            ->forAll(Set\Integers::above(0))
            ->then(function($size) {
                $stream = new ToPsr7(
                    $inner = $this->createMock(Readable::class)
                );
                $inner
                    ->expects($this->once())
                    ->method('size')
                    ->willReturn(Maybe::just(new Size($size)));

                $this->assertSame($size, $stream->getSize());
            });
    }

    public function testReturnNothingWhenTheSizeIsUnknown()
    {
        $stream = new ToPsr7(
            $inner = $this->createMock(Readable::class)
        );
        $inner
            ->expects($this->once())
            ->method('size')
            ->willReturn(Maybe::nothing());

        $this->assertNull($stream->getSize());
    }

    public function testTell()
    {
        $this
            ->forAll(Set\Integers::above(0))
            ->then(function($position) {
                $stream = new ToPsr7(
                    $inner = $this->createMock(Readable::class)
                );
                $inner
                    ->expects($this->once())
                    ->method('position')
                    ->willReturn(new Position($position));

                $this->assertSame($position, $stream->tell());
            });
    }

    public function testEof()
    {
        $this
            ->forAll(Set\Elements::of(true, false))
            ->then(function($eof) {
                $stream = new ToPsr7(
                    $inner = $this->createMock(Readable::class)
                );
                $inner
                    ->expects($this->once())
                    ->method('end')
                    ->willReturn($eof);

                $this->assertSame($eof, $stream->eof());
            });
    }

    public function testSeekOwnPositionToKnowIfStreamIsSeekable()
    {
        $this
            ->forAll(Set\Integers::above(0))
            ->then(function($position) {
                $stream = new ToPsr7(
                    $inner = $this->createMock(Readable::class)
                );
                $inner
                    ->expects($this->once())
                    ->method('position')
                    ->willReturn($position = new Position($position));
                $inner
                    ->expects($this->once())
                    ->method('seek')
                    ->with($position)
                    ->will($this->throwException(new PositionNotSeekable));

                $this->assertFalse($stream->isSeekable());
            });
        $this
            ->forAll(Set\Integers::above(0))
            ->then(function($position) {
                $stream = new ToPsr7(
                    $inner = $this->createMock(Readable::class)
                );
                $inner
                    ->expects($this->once())
                    ->method('position')
                    ->willReturn($position = new Position($position));
                $inner
                    ->expects($this->once())
                    ->method('seek')
                    ->with($position)
                    ->will($this->returnSelf());

                $this->assertTrue($stream->isSeekable());
            });
    }

    public function testSeek()
    {
        $this
            ->forAll(
                Set\Elements::of(null, \SEEK_CUR, \SEEK_SET),
                Set\Integers::above(0)
            )
            ->then(function($whence, $offset) {
                switch ($whence) {
                    case null:
                        $mode = Mode::fromStart();
                        break;

                    case \SEEK_SET:
                        $mode = Mode::fromStart();
                        break;

                    case \SEEK_CUR:
                        $mode = Mode::fromCurrentPosition();
                        break;
                }

                $stream = new ToPsr7(
                    $inner = $this->createMock(Readable::class)
                );
                $inner
                    ->expects($this->once())
                    ->method('seek')
                    ->with(
                        $this->callback(static function($position) use ($offset) {
                            return $position->toInt() === $offset;
                        }),
                        $mode
                    );

                $this->assertNull($stream->seek($offset, $whence));
            });
    }

    public function testThrowWhenSeekingFromEndOfStream()
    {
        $this
            ->forAll(Set\Integers::above(0))
            ->then(function($offset) {
                $stream = new ToPsr7(
                    $inner = $this->createMock(Readable::class)
                );
                $inner
                    ->expects($this->never())
                    ->method('seek');

                $this->expectException(LogicException::class);
                $this->expectExceptionMessage('SEEK_END not supported');

                $stream->seek($offset, \SEEK_END);
            });
    }

    public function testRewind()
    {
        $stream = new ToPsr7(
            $inner = $this->createMock(Readable::class)
        );
        $inner
            ->expects($this->once())
            ->method('rewind');

        $this->assertNull($stream->rewind());
    }

    public function testNotWritable()
    {
        $stream = new ToPsr7($this->createMock(Readable::class));

        $this->assertFalse($stream->isWritable());

        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('Immutable stream');

        $stream->write('foo');
    }

    public function testReadableOnlyWhenNotClosed()
    {
        $this
            ->forAll(Set\Elements::of(true, false))
            ->then(function($closed) {
                $stream = new ToPsr7(
                    $inner = $this->createMock(Readable::class)
                );
                $inner
                    ->expects($this->once())
                    ->method('closed')
                    ->willReturn($closed);

                $this->assertSame(!$closed, $stream->isReadable());
            });
    }

    public function testRead()
    {
        $this
            ->forAll(Set\Unicode::strings(), Set\Integers::above(0))
            ->then(function($content, $length) {
                $stream = new ToPsr7(
                    $inner = $this->createMock(Readable::class)
                );
                $inner
                    ->expects($this->once())
                    ->method('read')
                    ->with($length)
                    ->willReturn(Str::of($content));

                $this->assertSame($content, $stream->read($length));
            });
    }

    public function testGetContents()
    {
        $this
            ->forAll(Set\Unicode::strings())
            ->then(function($content) {
                $stream = new ToPsr7(
                    $inner = $this->createMock(Readable::class)
                );
                $inner
                    ->expects($this->once())
                    ->method('read')
                    ->with($this->isNull())
                    ->willReturn(Str::of($content));

                $this->assertSame($content, $stream->getContents());
            });
    }

    public function testNeverReturnAMetadata()
    {
        $this
            ->forAll(Set\Unicode::strings())
            ->then(function($key) {
                $stream = new ToPsr7(
                    $this->createMock(Readable::class)
                );

                $this->assertNull($stream->getMetadata($key));
                $this->assertNull($stream->getMetadata());
            });
    }
}

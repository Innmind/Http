<?php
declare(strict_types = 1);

namespace Innmind\Http\Bridge\Psr7;

use Innmind\Http\Exception\LogicException;
use Innmind\Stream\{
    Readable,
    Stream as StreamInterface,
    Stream\Position,
    Stream\Position\Mode,
    Stream\Size,
    Exception\UnknownSize,
};
use Innmind\Immutable\Str;
use Psr\Http\Message\StreamInterface as PsrStream;

final class Stream implements Readable
{
    private PsrStream $stream;
    private bool $closed = false;

    public function __construct(PsrStream $stream)
    {
        $this->stream = $stream;
    }

    public function close(): void
    {
        $this->stream->close();
        $this->closed = true;
    }

    public function closed(): bool
    {
        return $this->closed;
    }

    public function position(): Position
    {
        return new Position($this->stream->tell());
    }

    public function seek(Position $position, Mode $mode = null): void
    {
        $this->stream->seek($position->toInt(), $mode ? $mode->toInt() : \SEEK_SET);
    }

    public function rewind(): void
    {
        $this->stream->rewind();
    }

    public function end(): bool
    {
        return $this->stream->eof();
    }

    public function size(): Size
    {
        $size = $this->stream->getSize();

        if (!\is_int($size)) {
            throw new UnknownSize;
        }

        return new Size($size);
    }

    public function knowsSize(): bool
    {
        return \is_int($this->stream->getSize());
    }

    /**
     * {@inheritdoc}
     */
    public function read(int $length = null): Str
    {
        if (\is_null($length)) {
            return Str::of($this->stream->getContents());
        }

        return Str::of($this->stream->read($length));
    }

    public function readLine(): Str
    {
        throw new LogicException('not implemented');
    }

    public function toString(): string
    {
        return (string) $this->stream;
    }
}

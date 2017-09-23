<?php
declare(strict_types = 1);

namespace Innmind\Http\Bridge\Psr7;

use Innmind\Http\Exception\LogicException;
use Innmind\Stream\{
    Readable,
    Stream as StreamInterface,
    Stream\Position,
    Stream\Position\Mode,
    Stream\Size
};
use Innmind\Immutable\Str;
use Psr\Http\Message\StreamInterface as PsrStream;

final class Stream implements Readable
{
    private $stream;
    private $closed = false;

    public function __construct(PsrStream $stream)
    {
        $this->stream = $stream;
    }

    public function close(): StreamInterface
    {
        $this->stream->close();
        $this->closed = true;

        return $this;
    }

    public function closed(): bool
    {
        return $this->closed;
    }

    public function position(): Position
    {
        return new Position($this->stream->tell());
    }

    public function seek(Position $position, Mode $mode = null): StreamInterface
    {
        $this->stream->seek($position->toInt(), $mode->toInt());

        return $this;
    }

    public function rewind(): StreamInterface
    {
        $this->stream->rewind();

        return $this;
    }

    public function end(): bool
    {
        return $this->stream->eof();
    }

    public function size(): Size
    {
        return new Size($this->stream->getSize());
    }

    public function knowsSize(): bool
    {
        return is_int($this->stream->getSize());
    }

    /**
     * {@inheritdoc}
     */
    public function read(int $length = null): Str
    {
        if (is_null($length)) {
            return new Str($this->stream->getContents());
        }

        return new Str($this->stream->read($length));
    }

    public function readLine(): Str
    {
        throw new LogicException('not implemented');
    }

    public function __toString(): string
    {
        return (string) $this->stream;
    }
}

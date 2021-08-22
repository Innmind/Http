<?php
declare(strict_types = 1);

namespace Innmind\Http\Stream;

use Innmind\Http\Exception\LogicException;
use Innmind\Stream\{
    Readable,
    Selectable,
    Stream\Position,
    Stream\Position\Mode,
    Exception\PositionNotSeekable,
};
use Psr\Http\Message\StreamInterface;

final class ToPsr7 implements StreamInterface
{
    private Readable $stream;

    public function __construct(Readable $stream)
    {
        $this->stream = $stream;
    }

    public function __toString()
    {
        return $this->stream->toString();
    }

    public function close()
    {
        $this->stream->close();
    }

    public function detach()
    {
        if ($this->stream instanceof Selectable) {
            return $this->stream->resource();
        }
    }

    public function getSize()
    {
        return $this->stream->size()->match(
            static fn($size) => $size->toInt(),
            static fn() => null,
        );
    }

    public function tell()
    {
        return $this->stream->position()->toInt();
    }

    public function eof()
    {
        return $this->stream->end();
    }

    public function isSeekable()
    {
        try {
            $this->stream->seek($this->stream->position());

            return true;
        } catch (PositionNotSeekable $e) {
            return false;
        }
    }

    public function seek($offset, $whence = \SEEK_SET): void
    {
        switch ($whence) {
            case \SEEK_SET:
                $mode = Mode::fromStart();
                break;

            case \SEEK_CUR:
                $mode = Mode::fromCurrentPosition();
                break;

            case \SEEK_END:
                throw new LogicException('SEEK_END not supported');

            default:
                throw new LogicException("Unknown whence $whence");
        }

        $this->stream->seek(new Position($offset), $mode);
    }

    public function rewind(): void
    {
        $this->stream->rewind();
    }

    public function isWritable()
    {
        return false;
    }

    /**
     * Write data to the stream.
     *
     * @param string $string The string that is to be written.
     * @throws \RuntimeException on failure.
     * @return int Returns the number of bytes written to the stream.
     */
    public function write($string)
    {
        throw new LogicException('Immutable stream');
    }

    public function isReadable()
    {
        return !$this->stream->closed();
    }

    public function read($length)
    {
        return $this->stream->read($length)->toString();
    }

    public function getContents()
    {
        return $this->stream->read()->toString();
    }

    public function getMetadata($key = null)
    {
    }
}

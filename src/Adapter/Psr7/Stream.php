<?php
declare(strict_types = 1);

namespace Innmind\Http\Adapter\Psr7;

use Innmind\Http\Exception\LogicException;
use Innmind\Stream\{
    Readable,
    Selectable,
    Stream\Position,
    Stream\Position\Mode,
    Exception\PositionNotSeekable,
};
use Psr\Http\Message\StreamInterface;

/**
 * For the reverse adapter see Innmind\Http\Bridge\Psr7\Stream
 */
final class Stream implements StreamInterface
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

    /**
     * {@inheritdoc}
     */
    public function close()
    {
        $this->stream->close();
    }

    /**
     * {@inheritdoc}
     */
    public function detach()
    {
        if ($this->stream instanceof Selectable) {
            return $this->stream->resource();
        }

        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function getSize()
    {
        if ($this->stream->knowsSize()) {
            return $this->stream->size()->toInt();
        }

        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function tell()
    {
        return $this->stream->position()->toInt();
    }

    /**
     * {@inheritdoc}
     */
    public function eof()
    {
        return $this->stream->end();
    }

    /**
     * {@inheritdoc}
     */
    public function isSeekable()
    {
        try {
            $this->stream->seek($this->stream->position());

            return true;
        } catch (PositionNotSeekable $e) {
            return false;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function seek($offset, $whence = SEEK_SET): void
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

    /**
     * {@inheritdoc}
     */
    public function rewind(): void
    {
        $this->stream->rewind();
    }

    /**
     * {@inheritdoc}
     */
    public function isWritable()
    {
        return false;
    }

    /**
     * Write data to the stream.
     *
     * @param string $string The string that is to be written.
     * @return int Returns the number of bytes written to the stream.
     * @throws \RuntimeException on failure.
     */
    public function write($string)
    {
        throw new LogicException('Immutable stream');
    }

    /**
     * {@inheritdoc}
     */
    public function isReadable()
    {
        return !$this->stream->closed();
    }

    /**
     * {@inheritdoc}
     */
    public function read($length)
    {
        return $this->stream->read($length)->toString();
    }

    /**
     * {@inheritdoc}
     */
    public function getContents()
    {
        return $this->stream->read()->toString();
    }

    /**
     * {@inheritdoc}
     */
    public function getMetadata($key = null)
    {
        return null;
    }
}

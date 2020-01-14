<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Bridge\Psr7;

use Innmind\Http\Bridge\Psr7\Stream;
use Innmind\Stream\{
    Readable,
    Stream\Position,
    Stream\Position\Mode
};
use Psr\Http\Message\StreamInterface;
use PHPUnit\Framework\TestCase;

class StreamTest extends TestCase
{
    public function testInterface()
    {
        $stream = new Stream(
            $psr = $this->createMock(StreamInterface::class)
        );
        $psr
            ->expects($this->once())
            ->method('tell')
            ->willReturn(42);
        $psr
            ->expects($this->once())
            ->method('seek')
            ->with(24, SEEK_SET);
        $psr
            ->expects($this->once())
            ->method('rewind');
        $psr
            ->expects($this->exactly(2))
            ->method('eof')
            ->will($this->onConsecutiveCalls(false, true));
        $psr
            ->expects($this->exactly(3))
            ->method('getSize')
            ->will($this->onConsecutiveCalls(null, 24, 66));
        $psr
            ->expects($this->once())
            ->method('getContents')
            ->willReturn('full');
        $psr
            ->expects($this->once())
            ->method('read')
            ->with(43)
            ->willReturn('partial');
        $psr
            ->expects($this->once())
            ->method('__toString')
            ->willReturn('cast');

        $this->assertInstanceOf(Readable::class, $stream);
        $this->assertFalse($stream->closed());
        $this->assertNull($stream->close());
        $this->assertTrue($stream->closed());
        $this->assertSame(42, $stream->position()->toInt());
        $this->assertNull($stream->seek(new Position(24), Mode::fromStart()));
        $this->assertNull($stream->rewind());
        $this->assertFalse($stream->end());
        $this->assertTrue($stream->end());
        $this->assertFalse($stream->knowsSize());
        $this->assertTrue($stream->knowsSize());
        $this->assertSame(66, $stream->size()->toInt());
        $this->assertSame('full', $stream->read()->toString());
        $this->assertSame('partial', $stream->read(43)->toString());
        $this->assertSame('cast', $stream->toString());
    }
}

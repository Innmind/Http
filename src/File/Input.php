<?php
declare(strict_types = 1);

namespace Innmind\Http\File;

use Innmind\Filesystem\{
    File\Content,
    File\Content\Lines,
    File\Content\Line,
    File\Content\Chunkable,
    Exception\FailedToLoadFile,
};
use Innmind\Stream\Readable;
use Innmind\Immutable\{
    Sequence,
    SideEffect,
    Str,
    Either,
    Maybe,
};

/**
 * @internal
 * @psalm-immutable
 *
 * This is a copy of Filesystem\File\Content\OfStream but without the call to
 * rewind as php://input is not rewindable
 */
final class Input implements Content, Chunkable
{
    /** @var callable(): Readable */
    private $load;
    private bool $loaded = false;

    /**
     * @param callable(): Readable $load
     */
    private function __construct(callable $load)
    {
        $this->load = $load;
    }

    /**
     * @psalm-pure
     */
    public static function of(Readable $stream): self
    {
        return new self(static fn() => $stream);
    }

    public function foreach(callable $function): SideEffect
    {
        return $this->lines()->foreach($function);
    }

    public function map(callable $map): Content
    {
        return Lines::of($this->lines()->map($map));
    }

    public function flatMap(callable $map): Content
    {
        return Lines::of($this->lines())->flatMap($map);
    }

    public function filter(callable $filter): Content
    {
        return Lines::of($this->lines()->filter($filter));
    }

    public function lines(): Sequence
    {
        return $this
            ->sequence()
            ->map(static fn($line) => Line::fromStream($line));
    }

    public function reduce($carry, callable $reducer)
    {
        return $this->lines()->reduce($carry, $reducer);
    }

    public function size(): Maybe
    {
        return $this->load()->size();
    }

    public function toString(): string
    {
        $lines = $this
            ->sequence()
            ->map(static fn($line) => $line->toString());

        return Str::of('')->join($lines)->toString();
    }

    public function chunks(): Sequence
    {
        return $this->sequence(static fn(Readable $stream) => $stream->read(8192));
    }

    /**
     * @param ?callable(Readable): Maybe<Str> $read
     *
     * @return Sequence<Str>
     */
    private function sequence(callable $read = null): Sequence
    {
        /** @var callable(Readable): Maybe<Str> */
        $read ??= static fn(Readable $stream): Maybe => $stream->readLine();

        return Sequence::lazy(function() use ($read) {
            $stream = $this->load();

            while (!$stream->end()) {
                // we yield an empty line when the readLine() call doesn't return
                // anything otherwise it will fail to load empty files or files
                // ending with the "end of line" character
                yield $read($stream)->match(
                    static fn($line) => $line,
                    static fn() => Str::of(''),
                );
            }
        });
    }

    private function load(): Readable
    {
        if ($this->loaded) {
            // because the resource is not rewindable
            throw new FailedToLoadFile("Request input can't be loaded mutliple times");
        }

        /** @psalm-suppress InaccessibleProperty */
        $this->loaded = true;

        /** @psalm-suppress ImpureFunctionCall */
        return ($this->load)();
    }
}

<?php
declare(strict_types = 1);

namespace Innmind\Http\Content;

use Innmind\Http\{
    Content\Multipart\Data,
    Content\Multipart\File,
    Header\ContentType\Boundary,
};
use Innmind\Filesystem\{
    File as Binary,
    File\Content,
    File\Content\Chunkable,
};
use Innmind\Stream\Stream\Size;
use Innmind\Immutable\{
    Sequence,
    Str,
    Maybe,
    SideEffect,
};

/**
 * @psalm-immutable
 */
final class Multipart implements Content, Chunkable
{
    private Boundary $boundary;
    /** @var Sequence<Data|File> */
    private Sequence $parts;

    /**
     * @param Sequence<Data|File> $parts
     */
    private function __construct(Boundary $boundary, Sequence $parts)
    {
        $this->boundary = $boundary;
        $this->parts = $parts;
    }

    /**
     * @psalm-pure
     */
    public static function boundary(Boundary $boundary): self
    {
        /** @var Sequence<Data|File> */
        $parts = Sequence::of();

        return new self($boundary, $parts);
    }

    public function with(string $name, string $data): self
    {
        return new self(
            $this->boundary,
            ($this->parts)(new Data($name, $data)),
        );
    }

    public function withFile(string $name, Binary $file): self
    {
        return new self(
            $this->boundary,
            ($this->parts)(new File($name, $file)),
        );
    }

    public function foreach(callable $function): SideEffect
    {
        return $this->content()->foreach($function);
    }

    public function map(callable $map): Content
    {
        return $this->content()->map($map);
    }

    public function flatMap(callable $map): Content
    {
        return $this->content()->flatMap($map);
    }

    public function filter(callable $filter): Content
    {
        return $this->content()->filter($filter);
    }

    public function lines(): Sequence
    {
        return $this->content()->lines();
    }

    public function chunks(): Sequence
    {
        $boundary = $this->boundaryStr();
        $boundaryLine = Sequence::lazyStartingWith($boundary->append("\r\n"));

        if ($this->parts->empty()) {
            return $boundaryLine->add($boundary->append('--'));
        }

        return $this
            ->parts
            ->flatMap(static fn($part) => $boundaryLine
                ->append($part->chunks())
                ->add(Str::of("\r\n")),
            )
            ->add($boundary->append('--'));
    }

    public function reduce($carry, callable $reducer)
    {
        return $this->content()->reduce($carry, $reducer);
    }

    public function size(): Maybe
    {
        // +2 for carriage return and -- (for last boundary)
        $boundary = $this->boundaryStr()->toEncoding('ASCII')->length() + 2;

        if ($this->parts->empty()) {
            return Maybe::just(new Size($boundary + $boundary));
        }

        /** @var Maybe<int> */
        $parts = $this
            ->parts
            ->map(
                static fn($part) => $part
                    ->size()
                    ->map(static fn($size) => $boundary + $size + 2),
            )
            ->match(
                static fn($first, $rest) => Maybe::all($first, ...$rest->toList())->map(
                    static fn(int ...$sizes) => \array_sum($sizes),
                ),
                static fn() => Maybe::nothing(),
            );

        return $parts
            ->map(static fn($size) => $size + $boundary)
            ->map(static fn($size) => new Size($size));
    }

    public function toString(): string
    {
        return $this->content()->toString();
    }

    private function content(): Content
    {
        return Content\Chunks::of($this->chunks());
    }

    private function boundaryStr(): Str
    {
        return Str::of('--'.$this->boundary->value());
    }
}

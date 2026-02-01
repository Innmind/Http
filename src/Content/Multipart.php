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
};
use Innmind\Immutable\{
    Sequence,
    Str,
};

/**
 * @psalm-immutable
 */
final class Multipart
{
    /**
     * @param Sequence<Data|File> $parts
     */
    private function __construct(
        private Boundary $boundary,
        private Sequence $parts,
    ) {
    }

    /**
     * @psalm-pure
     */
    #[\NoDiscard]
    public static function boundary(Boundary $boundary): self
    {
        /** @var Sequence<Data|File> */
        $parts = Sequence::of();

        return new self($boundary, $parts);
    }

    #[\NoDiscard]
    public function with(string $name, string $data): self
    {
        return new self(
            $this->boundary,
            ($this->parts)(new Data($name, $data)),
        );
    }

    #[\NoDiscard]
    public function withFile(string $name, Binary $file): self
    {
        return new self(
            $this->boundary,
            ($this->parts)(new File($name, $file)),
        );
    }

    #[\NoDiscard]
    public function asContent(): Content
    {
        return Content::ofChunks($this->chunks());
    }

    /**
     * @return Sequence<Str>
     */
    private function chunks(): Sequence
    {
        $boundary = $this->boundaryStr();
        $boundaryLine = Sequence::of($boundary->append("\r\n"));

        if ($this->parts->empty()) {
            return $boundaryLine->add($boundary->append('--'));
        }

        return $this
            ->parts
            ->flatMap(static fn($part) => $part
                ->chunks()
                ->prepend($boundaryLine)
                ->add(Str::of("\r\n")),
            )
            ->add($boundary->append('--'));
    }

    private function boundaryStr(): Str
    {
        return Str::of('--'.$this->boundary->value());
    }
}

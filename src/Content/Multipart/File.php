<?php
declare(strict_types = 1);

namespace Innmind\Http\Content\Multipart;

use Innmind\Filesystem\{
    File as Binary,
    Chunk,
};
use Innmind\Immutable\{
    Sequence,
    Str,
    Maybe,
    Monoid\Concat,
};

/**
 * @internal
 */
final class File
{
    private string $name;
    private Binary $file;

    public function __construct(string $name, Binary $file)
    {
        $this->name = $name;
        $this->file = $file;
    }

    /**
     * @return Sequence<Str>
     */
    public function chunks(): Sequence
    {
        return $this
            ->headers()
            ->append((new Chunk)($this->file->content()));
    }

    /**
     * @return Maybe<int>
     */
    public function size(): Maybe
    {
        $headers = $this
            ->headers()
            ->fold(new Concat)
            ->toEncoding('ASCII')
            ->length();

        return $this
            ->file
            ->content()
            ->size()
            ->map(static fn($size) => $size->toInt())
            ->map(static fn($size) => $headers + $size);
    }

    /**
     * @return Sequence<Str>
     */
    private function headers(): Sequence
    {
        $name = $this->file->name()->toString();
        $mediaType = $this->file->mediaType()->toString();
        $headers = Sequence::of(
            Str::of("Content-Disposition: form-data; name=\"{$this->name}\"; filename=\"$name\"\r\n"),
            Str::of("Content-Type: $mediaType\r\n"),
        );

        return $this
            ->file
            ->content()
            ->size()
            ->map(static fn($size) => $size->toInt())
            ->match(
                static fn($size) => $headers->add(Str::of("Content-Length: $size\r\n")),
                static fn() => $headers,
            )
            ->add(Str::of("\r\n"));
    }
}
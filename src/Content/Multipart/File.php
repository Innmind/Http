<?php
declare(strict_types = 1);

namespace Innmind\Http\Content\Multipart;

use Innmind\Filesystem\File as Binary;
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
            ->append($this->file->content()->chunks());
    }

    /**
     * @return Maybe<int>
     */
    public function size(): Maybe
    {
        $headers = $this
            ->headers()
            ->fold(new Concat)
            ->toEncoding(Str\Encoding::ascii)
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
        // Use a lazy Sequence here to prevent loading the whole file in memory
        // when the the chunks are appended to the headers in self::chunks()
        $headers = Sequence::lazyStartingWith(
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

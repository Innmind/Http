<?php
declare(strict_types = 1);

namespace Innmind\Http\Content\Multipart;

use Innmind\Immutable\{
    Sequence,
    Str,
    Maybe,
    Monoid\Concat,
};

/**
 * @internal
 */
final class Data
{
    public function __construct(
        private string $name,
        private string $value,
    ) {
    }

    /**
     * @return Sequence<Str>
     */
    public function chunks(): Sequence
    {
        return Sequence::of(
            Str::of("Content-Disposition: form-data; name=\"{$this->name}\"\r\n"),
            Str::of("\r\n"),
            Str::of($this->value),
        );
    }

    /**
     * @return Maybe<int>
     */
    public function size(): Maybe
    {
        return Maybe::just(
            $this
                ->chunks()
                ->fold(new Concat)
                ->toEncoding(Str\Encoding::ascii)
                ->length(),
        );
    }
}

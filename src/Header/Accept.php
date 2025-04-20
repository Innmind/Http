<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\{
    Header,
    Header\Accept\MediaType,
};
use Innmind\Immutable\Sequence;

/**
 * @psalm-immutable
 */
final class Accept implements Custom
{
    /**
     * @param Sequence<MediaType> $values
     */
    private function __construct(
        private Sequence $values,
    ) {
    }

    /**
     * @psalm-pure
     */
    public static function of(MediaType $first, MediaType ...$values): self
    {
        return new self(Sequence::of($first, ...$values));
    }

    #[\Override]
    public function normalize(): Header
    {
        return new Header(
            'Accept',
            ...$this
                ->values
                ->map(static fn($value) => new Value($value->toString()))
                ->toList(),
        );
    }
}

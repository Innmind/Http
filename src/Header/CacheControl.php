<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Header;
use Innmind\Immutable\Sequence;

/**
 * @psalm-immutable
 */
final class CacheControl implements Custom
{
    /**
     * @param Sequence<CacheControlValue> $directives
     */
    private function __construct(
        private Sequence $directives,
    ) {
    }

    /**
     * @psalm-pure
     * @no-named-arguments
     */
    public static function of(
        CacheControlValue $first,
        CacheControlValue ...$values,
    ): self {
        return new self(Sequence::of($first, ...$values));
    }

    #[\Override]
    public function normalize(): Header
    {
        return new Header(
            'Cache-Control',
            ...$this
                ->directives
                ->map(static fn($directive) => new Value\Value($directive->toString()))
                ->toList(),
        );
    }
}

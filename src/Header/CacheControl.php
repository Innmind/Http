<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\{
    Header,
    Header\CacheControl\Directive,
    Header\CacheControl\MaxAge,
    Header\CacheControl\MaxStale,
    Header\CacheControl\MinimumFresh,
    Header\CacheControl\NoCache,
    Header\CacheControl\PrivateCache,
    Header\CacheControl\SharedMaxAge,
};
use Innmind\Immutable\Sequence;

/**
 * @psalm-immutable
 */
final class CacheControl implements Custom
{
    /**
     * @param Sequence<Directive|MaxAge|MaxStale|MinimumFresh|NoCache|PrivateCache|SharedMaxAge> $directives
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
        Directive|MaxAge|MaxStale|MinimumFresh|NoCache|PrivateCache|SharedMaxAge $first,
        Directive|MaxAge|MaxStale|MinimumFresh|NoCache|PrivateCache|SharedMaxAge ...$values,
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
                ->map(static fn($directive) => new Value($directive->toString()))
                ->toList(),
        );
    }
}

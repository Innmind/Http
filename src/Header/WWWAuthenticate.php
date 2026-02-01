<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\{
    Header,
    Header\WWWAuthenticate\Challenge,
};
use Innmind\Immutable\Sequence;

/**
 * @psalm-immutable
 */
final class WWWAuthenticate implements Custom
{
    /**
     * @param Sequence<Challenge> $challenges
     */
    private function __construct(
        private Sequence $challenges,
    ) {
    }

    /**
     * @psalm-pure
     * @no-named-arguments
     */
    #[\NoDiscard]
    public static function of(Challenge ...$challenges): self
    {
        return new self(Sequence::of(...$challenges));
    }

    #[\Override]
    #[\NoDiscard]
    public function normalize(): Header
    {
        return Header::of(
            'WWW-Authenticate',
            ...$this
                ->challenges
                ->map(static fn($challenge) => Value::of($challenge->toString()))
                ->toList(),
        );
    }
}

<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\{
    Header,
    Header\Link\Relationship,
};
use Innmind\Immutable\Sequence;

/**
 * @psalm-immutable
 */
final class Link implements Custom
{
    /**
     * @param Sequence<Relationship> $relationships
     */
    private function __construct(
        private Sequence $relationships,
    ) {
    }

    /**
     * @psalm-pure
     * @no-named-arguments
     */
    public static function of(Relationship ...$relationships): self
    {
        return new self(Sequence::of(...$relationships));
    }

    #[\Override]
    public function normalize(): Header
    {
        return Header::of(
            'Link',
            ...$this
                ->relationships
                ->map(static fn($relationship) => Value::of($relationship->toString()))
                ->toList(),
        );
    }
}

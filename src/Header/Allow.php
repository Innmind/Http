<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\{
    Header,
    Method,
};
use Innmind\Immutable\Sequence;

/**
 * @psalm-immutable
 */
final class Allow implements Custom
{
    /**
     * @param Sequence<Method> $methods
     */
    private function __construct(
        private Sequence $methods,
    ) {
    }

    /**
     * @psalm-pure
     * @no-named-arguments
     */
    public static function of(Method ...$methods): self
    {
        return new self(Sequence::of(...$methods));
    }

    #[\Override]
    public function normalize(): Header
    {
        return new Header(
            'Allow',
            ...$this
                ->methods
                ->map(static fn($method) => new Value($method->toString()))
                ->toList(),
        );
    }
}

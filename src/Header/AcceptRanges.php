<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\{
    Header,
    Exception\DomainException,
};
use Innmind\Immutable\{
    Str,
    Maybe,
};

/**
 * @psalm-immutable
 */
final class AcceptRanges implements Custom
{
    private function __construct(
        private string $ranges,
    ) {
    }

    /**
     * @psalm-pure
     *
     * @throws DomainException
     */
    #[\NoDiscard]
    public static function of(string $range): self
    {
        return self::maybe($range)->match(
            static fn($self) => $self,
            static fn() => throw new DomainException($range),
        );
    }

    /**
     * @psalm-pure
     *
     * @return Maybe<self>
     */
    #[\NoDiscard]
    public static function maybe(string $range): Maybe
    {
        return Maybe::just($range)
            ->map(Str::of(...))
            ->filter(static fn($range) => $range->matches('~^\w+$~'))
            ->map(static fn() => new self($range));
    }

    #[\Override]
    #[\NoDiscard]
    public function normalize(): Header
    {
        return Header::of(
            'Accept-Ranges',
            Value::of($this->ranges),
        );
    }
}

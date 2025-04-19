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
final class AcceptRanges implements Provider
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
    public static function maybe(string $range): Maybe
    {
        return Maybe::just($range)
            ->map(Str::of(...))
            ->filter(static fn($range) => $range->matches('~^\w+$~'))
            ->map(static fn() => new self($range));
    }

    #[\Override]
    public function toHeader(): Header
    {
        return new Header(
            'Accept-Ranges',
            new Value\Value($this->ranges),
        );
    }
}

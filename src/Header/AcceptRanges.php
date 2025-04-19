<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\{
    Header as HeaderInterface,
    Exception\DomainException,
};
use Innmind\Immutable\{
    Sequence,
    Str,
    Maybe,
};

/**
 * @psalm-immutable
 */
final class AcceptRanges implements HeaderInterface
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
    public function name(): string
    {
        return 'Accept-Ranges';
    }

    #[\Override]
    public function values(): Sequence
    {
        return Sequence::of(new Value\Value($this->ranges));
    }

    #[\Override]
    public function toString(): string
    {
        return (new Header($this->name(), ...$this->values()->toList()))->toString();
    }
}

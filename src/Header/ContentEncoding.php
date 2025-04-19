<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\{
    Header as HeaderInterface,
    Exception\DomainException,
};
use Innmind\Immutable\{
    Sequence,
    Maybe,
    Str,
};

/**
 * @psalm-immutable
 */
final class ContentEncoding implements HeaderInterface
{
    private function __construct(
        private string $encoding,
    ) {
    }

    /**
     * @psalm-pure
     *
     * @throws DomainException
     */
    public static function of(string $encoding): self
    {
        return self::maybe($encoding)->match(
            static fn($self) => $self,
            static fn() => throw new DomainException($encoding),
        );
    }

    /**
     * @psalm-pure
     *
     * @return Maybe<self>
     */
    public static function maybe(string $encoding): Maybe
    {
        return Maybe::just($encoding)
            ->map(Str::of(...))
            ->filter(static fn($encoding) => $encoding->matches('~^[\w\-]+$~'))
            ->map(static fn() => new self($encoding));
    }

    #[\Override]
    public function name(): string
    {
        return 'Content-Encoding';
    }

    #[\Override]
    public function values(): Sequence
    {
        return Sequence::of(new Value\Value($this->encoding));
    }

    #[\Override]
    public function toString(): string
    {
        return (new Header($this->name(), ...$this->values()->toList()))->toString();
    }
}

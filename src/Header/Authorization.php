<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Exception\DomainException;
use Innmind\Immutable\{
    Str,
    Maybe,
};

/**
 * @psalm-immutable
 */
final class Authorization implements Provider
{
    public function __construct(
        private string $scheme,
        private string $parameter,
    ) {
    }

    /**
     * @psalm-pure
     */
    public static function of(string $scheme, string $parameter): self
    {
        return self::maybe($scheme, $parameter)->match(
            static fn($self) => $self,
            static fn() => throw new DomainException($scheme),
        );
    }

    /**
     * @psalm-pure
     *
     * @return Maybe<self>
     */
    public static function maybe(string $scheme, string $parameter): Maybe
    {
        return Maybe::just($scheme)
            ->map(Str::of(...))
            ->filter(static fn($scheme) => $scheme->matches('~^\w+$~'))
            ->map(static fn() => new self($scheme, $parameter));
    }

    public function scheme(): string
    {
        return $this->scheme;
    }

    public function parameter(): string
    {
        return $this->parameter;
    }

    #[\Override]
    public function toHeader(): Header
    {
        return new Header(
            'Authorization',
            new Value\Value(
                Str::of($this->scheme)
                    ->append(' ')
                    ->append($this->parameter)
                    ->trim()
                    ->toString(),
            ),
        );
    }
}

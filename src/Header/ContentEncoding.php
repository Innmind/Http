<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\{
    Header,
    Exception\DomainException,
};
use Innmind\Immutable\{
    Maybe,
    Str,
};

/**
 * @psalm-immutable
 */
final class ContentEncoding implements Custom
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
    public function normalize(): Header
    {
        return Header::of(
            'Content-Encoding',
            new Value($this->encoding),
        );
    }
}

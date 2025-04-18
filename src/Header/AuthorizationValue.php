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
final class AuthorizationValue implements Value
{
    private string $scheme;
    private string $parameter;

    public function __construct(string $scheme, string $parameter)
    {
        if (!Str::of($scheme)->matches('~^\w+$~')) {
            throw new DomainException($scheme);
        }

        $this->scheme = $scheme;
        $this->parameter = $parameter;
    }

    /**
     * @psalm-pure
     *
     * @return Maybe<self>
     */
    public static function of(string $scheme, string $parameter): Maybe
    {
        try {
            return Maybe::just(new self($scheme, $parameter));
        } catch (DomainException $e) {
            /** @var Maybe<self> */
            return Maybe::nothing();
        }
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
    public function toString(): string
    {
        return Str::of($this->scheme)
            ->append(' ')
            ->append($this->parameter)
            ->trim()
            ->toString();
    }
}

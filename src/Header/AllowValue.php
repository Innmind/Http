<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Message\Method;
use Innmind\Immutable\Maybe;

/**
 * @psalm-immutable
 */
final class AllowValue implements Value
{
    private string $value;

    public function __construct(string $value)
    {
        $this->value = Method::of($value)->toString();
    }

    /**
     * @psalm-pure
     *
     * @return Maybe<self>
     */
    public static function of(string $value): Maybe
    {
        return Method::maybe($value)->map(
            static fn($method) => new self($method->toString()),
        );
    }

    public function toString(): string
    {
        return $this->value;
    }
}

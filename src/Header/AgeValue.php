<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Exception\DomainException;
use Innmind\Immutable\Maybe;

/**
 * @psalm-immutable
 */
final class AgeValue implements Value
{
    /** @var 0|positive-int */
    private int $age;

    public function __construct(int $age)
    {
        if ($age < 0) {
            throw new DomainException((string) $age);
        }

        /** @var 0|positive-int */
        $this->age = $age;
    }

    /**
     * @psalm-pure
     *
     * @return Maybe<self>
     */
    public static function of(int $age): Maybe
    {
        try {
            return Maybe::just(new self($age));
        } catch (DomainException $e) {
            /** @var Maybe<self> */
            return Maybe::nothing();
        }
    }

    /**
     * @return 0|positive-int
     */
    public function age(): int
    {
        return $this->age;
    }

    public function toString(): string
    {
        return (string) $this->age;
    }
}

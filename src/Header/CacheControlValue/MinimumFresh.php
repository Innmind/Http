<?php
declare(strict_types = 1);

namespace Innmind\Http\Header\CacheControlValue;

use Innmind\Http\{
    Header\CacheControlValue,
    Exception\DomainException,
};
use Innmind\Immutable\Maybe;

/**
 * @psalm-immutable
 */
final class MinimumFresh implements CacheControlValue
{
    private int $age;

    public function __construct(int $age)
    {
        if ($age < 0) {
            throw new DomainException((string) $age);
        }

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

    public function age(): int
    {
        return $this->age;
    }

    #[\Override]
    public function toString(): string
    {
        return \sprintf(
            'min-fresh=%s',
            $this->age,
        );
    }
}

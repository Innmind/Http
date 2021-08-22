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
final class AcceptRangesValue implements Value
{
    private string $range;

    public function __construct(string $range)
    {
        if (!Str::of($range)->matches('~^\w+$~')) {
            throw new DomainException($range);
        }

        $this->range = $range;
    }

    /**
     * @psalm-pure
     *
     * @return Maybe<self>
     */
    public static function of(string $range): Maybe
    {
        try {
            return Maybe::just(new self($range));
        } catch (DomainException $e) {
            /** @var Maybe<self> */
            return Maybe::nothing();
        }
    }

    public function toString(): string
    {
        return $this->range;
    }
}

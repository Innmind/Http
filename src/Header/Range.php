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
final class Range implements Provider
{
    /**
     * @param int<0, max> $firstPosition
     * @param int<0, max> $lastPosition
     */
    private function __construct(
        private string $unit,
        private int $firstPosition,
        private int $lastPosition,
    ) {
    }

    /**
     * @psalm-pure
     *
     * @throws DomainException
     */
    public static function of(
        string $unit,
        int $firstPosition,
        int $lastPosition,
    ): self {
        return self::maybe($unit, $firstPosition, $lastPosition)->match(
            static fn($self) => $self,
            static fn() => throw new DomainException($unit),
        );
    }

    /**
     * @psalm-pure
     *
     * @return Maybe<self>
     */
    public static function maybe(
        string $unit,
        int $firstPosition,
        int $lastPosition,
    ): Maybe {
        if (
            !Str::of($unit)->matches('~^\w+$~') ||
            $firstPosition < 0 ||
            $lastPosition < 0 ||
            $firstPosition > $lastPosition
        ) {
            /** @var Maybe<self> */
            return Maybe::nothing();
        }

        return Maybe::just(new self($unit, $firstPosition, $lastPosition));
    }

    public function unit(): string
    {
        return $this->unit;
    }

    /**
     * @return int<0, max>
     */
    public function firstPosition(): int
    {
        return $this->firstPosition;
    }

    /**
     * @return int<0, max>
     */
    public function lastPosition(): int
    {
        return $this->lastPosition;
    }

    #[\Override]
    public function toHeader(): Header
    {
        return new Header(
            'Range',
            new Value\Value(\sprintf(
                '%s=%s-%s',
                $this->unit,
                $this->firstPosition,
                $this->lastPosition,
            )),
        );
    }
}

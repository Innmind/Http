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
final class ContentRange implements HeaderInterface
{
    /**
     * @param int<0, max> $firstPosition
     * @param int<0, max> $lastPosition
     * @param ?int<0, max> $length
     */
    private function __construct(
        private string $unit,
        private int $firstPosition,
        private int $lastPosition,
        private ?int $length,
    ) {
    }

    /**
     * @psalm-pure
     */
    public static function of(
        string $unit,
        int $firstPosition,
        int $lastPosition,
        ?int $length = null,
    ): self {
        return self::maybe($unit, $firstPosition, $lastPosition, $length)->match(
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
        ?int $length = null,
    ): Maybe {
        if (
            !Str::of($unit)->matches('~^\w+$~') ||
            $firstPosition < 0 ||
            $lastPosition < 0 ||
            ($length !== null && $length < 0) ||
            $firstPosition > $lastPosition ||
            ($length !== null && $lastPosition > $length)
        ) {
            /** @var Maybe<self> */
            return Maybe::nothing();
        }

        return Maybe::just(new self(
            $unit,
            $firstPosition,
            $lastPosition,
            $length,
        ));
    }

    #[\Override]
    public function name(): string
    {
        return $this->header()->name();
    }

    #[\Override]
    public function values(): Sequence
    {
        return $this->header()->values();
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

    /**
     * @return Maybe<int<0, max>>
     */
    public function length(): Maybe
    {
        return Maybe::of($this->length);
    }

    #[\Override]
    public function toString(): string
    {
        return $this->header()->toString();
    }

    private function header(): Header
    {
        return new Header(
            'Content-Range',
            new Value\Value(\sprintf(
                '%s %s-%s/%s',
                $this->unit,
                $this->firstPosition,
                $this->lastPosition,
                $this->length ?? '*',
            )),
        );
    }
}

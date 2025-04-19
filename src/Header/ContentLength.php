<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Header as HeaderInterface;
use Innmind\Immutable\{
    Sequence,
    Maybe,
};

/**
 * @psalm-immutable
 */
final class ContentLength implements HeaderInterface
{
    /**
     * @param int<0, max> $length
     */
    private function __construct(
        private int $length,
    ) {
    }

    /**
     * @psalm-pure
     *
     * @param int<0, max> $length
     */
    public static function of(int $length): self
    {
        return new self($length);
    }

    /**
     * @psalm-pure
     *
     * @return Maybe<self>
     */
    public static function maybe(int $length): Maybe
    {
        return Maybe::of(match (true) {
            $length >= 0 => new self($length),
            default => null,
        });
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

    /**
     * @return int<0, max>
     */
    public function length(): int
    {
        return $this->length;
    }

    #[\Override]
    public function toString(): string
    {
        return $this->header()->toString();
    }

    private function header(): Header
    {
        return new Header('Content-Length', new Value\Value((string) $this->length));
    }
}

<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Header;
use Innmind\Immutable\Maybe;

/**
 * @psalm-immutable
 */
final class ContentLength implements Custom
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

    /**
     * @return int<0, max>
     */
    public function length(): int
    {
        return $this->length;
    }

    #[\Override]
    public function normalize(): Header
    {
        return Header::of(
            'Content-Length',
            Value::of((string) $this->length),
        );
    }
}

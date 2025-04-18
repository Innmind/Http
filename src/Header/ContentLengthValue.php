<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Exception\DomainException;
use Innmind\Immutable\Maybe;

/**
 * @psalm-immutable
 */
final class ContentLengthValue implements Value
{
    /** @var 0|positive-int */
    private int $length;

    public function __construct(int $length)
    {
        if ($length < 0) {
            throw new DomainException((string) $length);
        }

        $this->length = $length;
    }

    /**
     * @psalm-pure
     *
     * @return Maybe<self>
     */
    public static function of(int $length): Maybe
    {
        try {
            return Maybe::just(new self($length));
        } catch (DomainException $e) {
            /** @var Maybe<self> */
            return Maybe::nothing();
        }
    }

    /**
     * @return 0|positive-int
     */
    public function length(): int
    {
        return $this->length;
    }

    #[\Override]
    public function toString(): string
    {
        return (string) $this->length;
    }
}

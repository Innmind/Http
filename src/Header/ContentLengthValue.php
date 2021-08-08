<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Exception\DomainException;

/**
 * @psalm-immutable
 */
final class ContentLengthValue implements Value
{
    private int $length;

    public function __construct(int $length)
    {
        if ($length < 0) {
            throw new DomainException((string) $length);
        }

        $this->length = $length;
    }

    public function toString(): string
    {
        return (string) $this->length;
    }
}

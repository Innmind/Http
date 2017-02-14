<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Exception\InvalidArgumentException;

final class ContentLengthValue extends HeaderValue
{
    public function __construct(int $length)
    {
        if ($length < 0) {
            throw new InvalidArgumentException;
        }

        parent::__construct((string) $length);
    }
}

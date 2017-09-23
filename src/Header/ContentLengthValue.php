<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Exception\DomainException;

final class ContentLengthValue extends HeaderValue\HeaderValue
{
    public function __construct(int $length)
    {
        if ($length < 0) {
            throw new DomainException;
        }

        parent::__construct((string) $length);
    }
}

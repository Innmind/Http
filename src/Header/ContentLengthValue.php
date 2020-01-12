<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Exception\DomainException;

final class ContentLengthValue extends Value\Value
{
    public function __construct(int $length)
    {
        if ($length < 0) {
            throw new DomainException((string) $length);
        }

        parent::__construct((string) $length);
    }
}

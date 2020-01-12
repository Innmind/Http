<?php
declare(strict_types = 1);

namespace Innmind\Http\Header\CookieParameter;

use Innmind\Http\{
    Header\Parameter\Parameter,
    Exception\DomainException,
};

final class MaxAge extends Parameter
{
    public function __construct(int $number)
    {
        if ($number < 1) {
            throw new DomainException;
        }

        parent::__construct('Max-Age', (string) $number);
    }

    public static function expire(): Parameter
    {
        return new Parameter('Max-Age', '-1');
    }
}

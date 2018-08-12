<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

final class Cookie extends Header
{
    public function __construct(CookieValue $value)
    {
        parent::__construct('Cookie', $value);
    }
}

<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

final class SetCookie extends Header
{
    public function __construct(CookieValue ...$values)
    {
        parent::__construct('Set-Cookie', ...$values);
    }

    public static function of(Parameter ...$values): self
    {
        return new self(new CookieValue(...$values));
    }
}

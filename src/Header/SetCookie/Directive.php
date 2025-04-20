<?php
declare(strict_types = 1);

namespace Innmind\Http\Header\SetCookie;

use Innmind\Http\Header\Parameter;

/**
 * @psalm-immutable
 */
enum Directive
{
    case laxSameSite;
    case strictSameSite;
    case secure;
    case httpOnly;

    public function toParameter(): Parameter
    {
        return match ($this) {
            self::laxSameSite => Parameter::of('SameSite', 'Lax'),
            self::strictSameSite => Parameter::of('SameSite', 'Strict'),
            self::secure => Parameter::of('Secure', ''),
            self::httpOnly => Parameter::of('HttpOnly', ''),
        };
    }
}

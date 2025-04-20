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
            self::laxSameSite => new Parameter('SameSite', 'Lax'),
            self::strictSameSite => new Parameter('SameSite', 'Strict'),
            self::secure => new Parameter('Secure', ''),
            self::httpOnly => new Parameter('HttpOnly', ''),
        };
    }
}

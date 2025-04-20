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
            self::laxSameSite => new Parameter\Parameter('SameSite', 'Lax'),
            self::strictSameSite => new Parameter\Parameter('SameSite', 'Strict'),
            self::secure => new Parameter\Parameter('Secure', ''),
            self::httpOnly => new Parameter\Parameter('HttpOnly', ''),
        };
    }
}

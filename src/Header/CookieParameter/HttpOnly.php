<?php
declare(strict_types = 1);

namespace Innmind\Http\Header\CookieParameter;

use Innmind\Http\Header\Parameter\Parameter;

/**
 * @psalm-immutable
 */
final class HttpOnly extends Parameter
{
    public function __construct()
    {
        parent::__construct('HttpOnly', '');
    }
}

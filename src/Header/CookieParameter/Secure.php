<?php
declare(strict_types = 1);

namespace Innmind\Http\Header\CookieParameter;

use Innmind\Http\Header\Parameter\Parameter;

final class Secure extends Parameter
{
    public function __construct()
    {
        parent::__construct('Secure', '');
    }
}

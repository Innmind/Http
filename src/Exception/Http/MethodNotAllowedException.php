<?php
declare(strict_types = 1);

namespace Innmind\Http\Exception\Http;

final class MethodNotAllowedException extends Exception
{
    public function httpCode(): int
    {
        return 405;
    }
}

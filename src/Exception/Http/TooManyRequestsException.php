<?php
declare(strict_types = 1);

namespace Innmind\Http\Exception\Http;

final class TooManyRequestsException extends Exception
{
    public function httpCode(): int
    {
        return 429;
    }
}
<?php
declare(strict_types = 1);

namespace Innmind\Http\Exception\Http;

final class NotFoundException extends Exception
{
    public function httpCode(): int
    {
        return 404;
    }
}
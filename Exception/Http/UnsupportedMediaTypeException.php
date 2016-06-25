<?php
declare(strict_types = 1);

namespace Innmind\Http\Exception\Http;

final class UnsupportedMediaTypeException extends Exception
{
    public function httpCode(): int
    {
        return 415;
    }
}

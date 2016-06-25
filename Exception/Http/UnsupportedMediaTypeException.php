<?php
declare(strict_types = 1);

namespace Innmind\Http\Exception\Http;

final class UnsupportedMediaTypeException implements ExceptionInterface
{
    public function httpCode(): int
    {
        return 415;
    }
}

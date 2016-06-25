<?php
declare(strict_types = 1);

namespace Innmind\Http\Exception\Http;

final class NotAcceptableException implements ExceptionInterface
{
    public function httpCode(): int
    {
        return 406;
    }
}

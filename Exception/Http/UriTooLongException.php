<?php
declare(strict_types = 1);

namespace Innmind\Http\Exception\Http;

final class UriTooLongException implements ExceptionInterface
{
    public function httpCode(): int
    {
        return 414;
    }
}

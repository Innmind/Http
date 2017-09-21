<?php
declare(strict_types = 1);

namespace Innmind\Http\Exception\Http;

final class NotAcceptableException extends AbstractException
{
    public function httpCode(): int
    {
        return 406;
    }
}

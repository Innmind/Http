<?php
declare(strict_types = 1);

namespace Innmind\Http\Exception\Http;

final class UnprocessableEntityException extends AbstractException
{
    public function httpCode(): int
    {
        return 422;
    }
}

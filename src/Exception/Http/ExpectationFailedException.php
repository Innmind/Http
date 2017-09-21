<?php
declare(strict_types = 1);

namespace Innmind\Http\Exception\Http;

final class ExpectationFailedException extends AbstractException
{
    public function httpCode(): int
    {
        return 417;
    }
}

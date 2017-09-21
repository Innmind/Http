<?php
declare(strict_types = 1);

namespace Innmind\Http\Exception\Http;

final class PreconditionRequired extends AbstractException
{
    public function httpCode(): int
    {
        return 428;
    }
}

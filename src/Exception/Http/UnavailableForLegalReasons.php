<?php
declare(strict_types = 1);

namespace Innmind\Http\Exception\Http;

final class UnavailableForLegalReasons extends AbstractException
{
    public function httpCode(): int
    {
        return 451;
    }
}

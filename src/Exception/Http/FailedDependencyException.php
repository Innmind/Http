<?php
declare(strict_types = 1);

namespace Innmind\Http\Exception\Http;

final class FailedDependencyException extends AbstractException
{
    public function httpCode(): int
    {
        return 424;
    }
}

<?php
declare(strict_types = 1);

namespace Innmind\Http\Message;

interface StatusCodeInterface
{
    public function value(): int;
    public function __toString(): string;
}

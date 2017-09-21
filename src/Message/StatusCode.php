<?php
declare(strict_types = 1);

namespace Innmind\Http\Message;

interface StatusCode
{
    public function value(): int;
    public function __toString(): string;
}

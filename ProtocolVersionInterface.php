<?php
declare(strict_types = 1);

namespace Innmind\Http;

interface ProtocolVersionInterface
{
    public function value(): float;
    public function __toString(): string;
}

<?php
declare(strict_types = 1);

namespace Innmind\Http;

interface ProtocolVersionInterface
{
    public function major(): int;
    public function minor(): int;
    public function __toString(): string;
}

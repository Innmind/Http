<?php
declare(strict_types = 1);

namespace Innmind\Http;

interface ProtocolVersion
{
    public function major(): int;
    public function minor(): int;
    public function __toString(): string;
}

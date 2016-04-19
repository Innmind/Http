<?php
declare(strict_types = 1);

namespace Innmind\Http\Message\File;

interface StatusInterface
{
    public function value(): int;
    public function __toString(): string;
}

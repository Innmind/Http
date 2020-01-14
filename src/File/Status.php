<?php
declare(strict_types = 1);

namespace Innmind\Http\File;

interface Status
{
    public function value(): int;
    public function toString(): string;
}

<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

/**
 * @psalm-immutable
 */
interface Value
{
    public function toString(): string;
}

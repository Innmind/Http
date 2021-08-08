<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

/**
 * @psalm-immutable
 */
interface Parameter
{
    public function name(): string;
    public function value(): string;
    public function toString(): string;
}

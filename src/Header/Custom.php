<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Header;

/**
 * @psalm-immutable
 */
interface Custom
{
    public function normalize(): Header;
}

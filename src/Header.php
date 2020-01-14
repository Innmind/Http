<?php
declare(strict_types = 1);

namespace Innmind\Http;

use Innmind\Immutable\Set;

interface Header
{
    public function name(): string;

    /**
     * @return Set<Header\Value>
     */
    public function values(): Set;
    public function toString(): string;
}

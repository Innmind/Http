<?php
declare(strict_types = 1);

namespace Innmind\Http;

use Innmind\Immutable\Set;

/**
 * @template V of Header\Value
 * @psalm-immutable
 */
interface Header
{
    public function name(): string;

    /**
     * @return Set<V>
     */
    public function values(): Set;
    public function toString(): string;
}

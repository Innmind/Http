<?php
declare(strict_types = 1);

namespace Innmind\Http;

use Innmind\Immutable\Sequence;

/**
 * @psalm-immutable
 */
interface Header
{
    public function name(): string;

    /**
     * @return Sequence<Header\Value>
     */
    public function values(): Sequence;
    public function toString(): string;
}

<?php
declare(strict_types = 1);

namespace Innmind\Http;

use Innmind\Immutable\SetInterface;

interface Header
{
    public function name(): string;

    /**
     * @return SetInterface<Value>
     */
    public function values(): SetInterface;
    public function toString(): string;
}

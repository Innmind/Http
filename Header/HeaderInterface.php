<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

interface HeaderInterface
{
    public function name(): string;

    /**
     * @return SetInterface<HeaderValueInterface>
     */
    public function values(): SetInterface;
    public function __toString(): string;
}

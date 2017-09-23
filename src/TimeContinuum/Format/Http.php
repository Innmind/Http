<?php
declare(strict_types = 1);

namespace Innmind\Http\TimeContinuum\Format;

use Innmind\TimeContinuum\FormatInterface;

final class Http implements FormatInterface
{
    public function __toString(): string
    {
        return \DateTime::RFC1123;
    }
}

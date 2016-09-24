<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\HeaderFactoryInterface,
    Header\Age,
    Header\AgeValue,
    Header\HeaderInterface
};
use Innmind\Immutable\StringPrimitive as Str;

final class AgeFactory implements HeaderFactoryInterface
{
    public function make(Str $name, Str $value): HeaderInterface
    {
        return new Age(
            new AgeValue(
                (int) (string) $value
            )
        );
    }
}

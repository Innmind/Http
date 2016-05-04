<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\HeaderFactoryInterface,
    Header\HeaderInterface,
    Header\RangeValue,
    Header\Range
};
use Innmind\Immutable\StringPrimitive as Str;

final class RangeFactory implements HeaderFactoryInterface
{
    public function make(Str $name, Str $value): HeaderInterface
    {
        $matches = $value->getMatches('~^(?<unit>\w+)=(?<first>\d+)-(?<last>\d+)$~');

        return new Range(
            new RangeValue(
                (string) $matches->get('unit'),
                (int) (string) $matches->get('first'),
                (int) (string) $matches->get('last')
            )
        );
    }
}

<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\HeaderFactoryInterface,
    Header\HeaderInterface,
    Header\ContentRange,
    Header\ContentRangeValue
};
use Innmind\Immutable\StringPrimitive as Str;

final class ContentRangeFactory implements HeaderFactoryInterface
{
    public function make(Str $name, Str $value): HeaderInterface
    {
        $matches = $value->trim()->getMatches(
            '~^(?<unit>\w+) (?<first>\d+)-(?<last>\d+)/(?<length>\d+|\*)$~'
        );
        $length = (string) $matches->get('length');

        return new ContentRange(
            new ContentRangeValue(
                (string) $matches->get('unit'),
                (int) (string) $matches->get('first'),
                (int) (string) $matches->get('last'),
                $length === '*' ? null : (int) $length
            )
        );
    }
}

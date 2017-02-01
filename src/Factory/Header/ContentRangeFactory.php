<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\HeaderFactoryInterface,
    Header\HeaderInterface,
    Header\ContentRange,
    Header\ContentRangeValue,
    Exception\InvalidArgumentException
};
use Innmind\Immutable\StringPrimitive as Str;

final class ContentRangeFactory implements HeaderFactoryInterface
{
    const PATTERN = '~^(?<unit>\w+) (?<first>\d+)-(?<last>\d+)/(?<length>\d+|\*)$~';

    public function make(Str $name, Str $value): HeaderInterface
    {
        $value = $value->trim();

        if (
            (string) $name->toLower() !== 'content-range' ||
            !$value->match(self::PATTERN)
        ) {
            throw new InvalidArgumentException;
        }

        $matches = $value->getMatches(self::PATTERN);
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

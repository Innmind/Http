<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\HeaderFactory as HeaderFactoryInterface,
    Header,
    Header\RangeValue,
    Header\Range,
    Exception\InvalidArgumentException
};
use Innmind\Immutable\Str;

final class RangeFactory implements HeaderFactoryInterface
{
    const PATTERN = '~^(?<unit>\w+)=(?<first>\d+)-(?<last>\d+)$~';

    public function make(Str $name, Str $value): Header
    {
        if (
            (string) $name->toLower() !== 'range' ||
            !$value->matches(self::PATTERN)
        ) {
            throw new InvalidArgumentException;
        }

        $matches = $value->capture(self::PATTERN);

        return new Range(
            new RangeValue(
                (string) $matches->get('unit'),
                (int) (string) $matches->get('first'),
                (int) (string) $matches->get('last')
            )
        );
    }
}

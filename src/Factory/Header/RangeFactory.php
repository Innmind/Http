<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\HeaderFactoryInterface,
    Header\HeaderInterface,
    Header\RangeValue,
    Header\Range,
    Exception\InvalidArgumentException
};
use Innmind\Immutable\Str;

final class RangeFactory implements HeaderFactoryInterface
{
    const PATTERN = '~^(?<unit>\w+)=(?<first>\d+)-(?<last>\d+)$~';

    public function make(Str $name, Str $value): HeaderInterface
    {
        if (
            (string) $name->toLower() !== 'range' ||
            !$value->matches(self::PATTERN)
        ) {
            throw new InvalidArgumentException;
        }

        $matches = $value->getMatches(self::PATTERN);

        return new Range(
            new RangeValue(
                (string) $matches->get('unit'),
                (int) (string) $matches->get('first'),
                (int) (string) $matches->get('last')
            )
        );
    }
}

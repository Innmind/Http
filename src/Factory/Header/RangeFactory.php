<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\HeaderFactory as HeaderFactoryInterface,
    Header,
    Header\RangeValue,
    Header\Range,
    Exception\DomainException
};
use Innmind\Immutable\Str;

final class RangeFactory implements HeaderFactoryInterface
{
    private const PATTERN = '~^(?<unit>\w+)=(?<first>\d+)-(?<last>\d+)$~';

    public function __invoke(Str $name, Str $value): Header
    {
        if (
            (string) $name->toLower() !== 'range' ||
            !$value->matches(self::PATTERN)
        ) {
            throw new DomainException;
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

<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\HeaderFactory as HeaderFactoryInterface,
    Header,
    Header\RangeValue,
    Header\Range,
    Exception\DomainException,
};
use Innmind\Immutable\{
    Str,
    Maybe,
};

final class RangeFactory implements HeaderFactoryInterface
{
    private const PATTERN = '~^(?<unit>\w+)=(?<first>\d+)-(?<last>\d+)$~';

    public function __invoke(Str $name, Str $value): Header
    {
        if (
            $name->toLower()->toString() !== 'range' ||
            !$value->matches(self::PATTERN)
        ) {
            throw new DomainException($name->toString());
        }

        $matches = $value->capture(self::PATTERN);

        return Maybe::all(
            $matches->get('unit'),
            $matches->get('first'),
            $matches->get('last'),
        )
            ->map(static fn(Str $unit, Str $first, Str $last) => new RangeValue(
                $unit->toString(),
                (int) $first->toString(),
                (int) $last->toString(),
            ))
            ->map(static fn($range) => new Range($range))
            ->match(
                static fn($range) => $range,
                static fn() => throw new DomainException($name->toString()),
            );
    }
}

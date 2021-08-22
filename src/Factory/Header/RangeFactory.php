<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\HeaderFactory,
    Header,
    Header\Range,
    Header\RangeValue,
};
use Innmind\Immutable\{
    Str,
    Maybe,
};

final class RangeFactory implements HeaderFactory
{
    private const PATTERN = '~^(?<unit>\w+)=(?<first>\d+)-(?<last>\d+)$~';

    public function __invoke(Str $name, Str $value): Maybe
    {
        if (
            $name->toLower()->toString() !== 'range' ||
            !$value->matches(self::PATTERN)
        ) {
            /** @var Maybe<Header> */
            return Maybe::nothing();
        }

        $matches = $value
            ->capture(self::PATTERN)
            ->map(static fn($_, $match) => $match->toString());

        /** @var Maybe<Header> */
        return Maybe::all(
            $matches->get('unit'),
            $matches->get('first')->filter(static fn($first) => \is_numeric($first)),
            $matches->get('last')->filter(static fn($last) => \is_numeric($last)),
        )
            ->flatMap(static fn(string $unit, string $first, string $last) => RangeValue::of(
                $unit,
                (int) $first,
                (int) $last,
            ))
            ->map(static fn($value) => new Range($value));
    }
}

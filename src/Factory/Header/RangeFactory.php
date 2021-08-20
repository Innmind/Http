<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\HeaderFactory,
    Header,
    Header\Range,
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

        $matches = $value->capture(self::PATTERN);

        /** @var Maybe<Header> */
        return Maybe::all(
            $matches->get('unit'),
            $matches->get('first'),
            $matches->get('last'),
        )
            ->map(static fn(Str $unit, Str $first, Str $last) => Range::of(
                $unit->toString(),
                (int) $first->toString(),
                (int) $last->toString(),
            ));
    }
}

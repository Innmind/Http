<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Header;

use Innmind\Http\{
    Header,
    Header\Range,
    Header\RangeValue,
};
use Innmind\Immutable\{
    Str,
    Maybe,
};

/**
 * @internal
 * @psalm-immutable
 */
final class RangeFactory implements Implementation
{
    private const PATTERN = '~^(?<unit>\w+)=(?<first>\d+)-(?<last>\d+)$~';

    #[\Override]
    public function __invoke(Str $value): Maybe
    {
        if (!$value->matches(self::PATTERN)) {
            /** @var Maybe<Header> */
            return Maybe::nothing();
        }

        $matches = $value
            ->capture(self::PATTERN)
            ->map(static fn($_, $match) => $match->toString());

        return Maybe::all(
            $matches->get('unit'),
            $matches->get('first')->filter(\is_numeric(...)),
            $matches->get('last')->filter(\is_numeric(...)),
        )
            ->flatMap(static fn(string $unit, string $first, string $last) => RangeValue::of(
                $unit,
                (int) $first,
                (int) $last,
            ))
            ->map(static fn($value) => new Range($value));
    }
}

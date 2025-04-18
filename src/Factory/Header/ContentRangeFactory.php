<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\HeaderFactory,
    Header,
    Header\ContentRange,
    Header\ContentRangeValue,
};
use Innmind\Immutable\{
    Str,
    Maybe,
};

/**
 * @psalm-immutable
 */
final class ContentRangeFactory implements HeaderFactory
{
    private const PATTERN = '~^(?<unit>\w+) (?<first>\d+)-(?<last>\d+)/(?<length>\d+|\*)$~';

    #[\Override]
    public function __invoke(Str $name, Str $value): Maybe
    {
        $value = $value->trim();

        if (
            $name->toLower()->toString() !== 'content-range' ||
            !$value->matches(self::PATTERN)
        ) {
            /** @var Maybe<Header> */
            return Maybe::nothing();
        }

        $matches = $value->capture(self::PATTERN);
        $length = $matches
            ->get('length')
            ->map(static fn($length) => $length->toString())
            ->filter(static fn($length) => $length !== '*')
            ->map(static fn($length) => (int) $length)
            ->match(
                static fn($length) => $length,
                static fn() => null,
            );

        /** @var Maybe<Header> */
        return Maybe::all($matches->get('unit'), $matches->get('first'), $matches->get('last'))
            ->flatMap(static fn(Str $unit, Str $first, Str $last) => ContentRangeValue::of(
                $unit->toString(),
                (int) $first->toString(),
                (int) $last->toString(),
                $length,
            ))
            ->map(static fn($value) => new ContentRange($value));
    }
}

<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\HeaderFactory as HeaderFactoryInterface,
    Header,
    Header\ContentRange,
    Header\ContentRangeValue,
    Exception\DomainException,
};
use Innmind\Immutable\{
    Str,
    Maybe,
};

final class ContentRangeFactory implements HeaderFactoryInterface
{
    private const PATTERN = '~^(?<unit>\w+) (?<first>\d+)-(?<last>\d+)/(?<length>\d+|\*)$~';

    public function __invoke(Str $name, Str $value): Header
    {
        $value = $value->trim();

        if (
            $name->toLower()->toString() !== 'content-range' ||
            !$value->matches(self::PATTERN)
        ) {
            throw new DomainException($name->toString());
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

        return Maybe::all($matches->get('unit'), $matches->get('first'), $matches->get('last'))
            ->map(static fn(Str $unit, Str $first, Str $last) => new ContentRangeValue(
                $unit->toString(),
                (int) $first->toString(),
                (int) $last->toString(),
                $length,
            ))
            ->map(static fn($value) => new ContentRange($value))
            ->match(
                static fn($range) => $range,
                static fn() => throw new DomainException,
            );
    }
}

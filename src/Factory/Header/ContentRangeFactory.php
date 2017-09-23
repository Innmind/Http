<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\HeaderFactory as HeaderFactoryInterface,
    Header,
    Header\ContentRange,
    Header\ContentRangeValue,
    Exception\DomainException
};
use Innmind\Immutable\Str;

final class ContentRangeFactory implements HeaderFactoryInterface
{
    const PATTERN = '~^(?<unit>\w+) (?<first>\d+)-(?<last>\d+)/(?<length>\d+|\*)$~';

    public function make(Str $name, Str $value): Header
    {
        $value = $value->trim();

        if (
            (string) $name->toLower() !== 'content-range' ||
            !$value->matches(self::PATTERN)
        ) {
            throw new DomainException;
        }

        $matches = $value->capture(self::PATTERN);
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

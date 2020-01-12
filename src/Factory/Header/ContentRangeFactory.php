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
    private const PATTERN = '~^(?<unit>\w+) (?<first>\d+)-(?<last>\d+)/(?<length>\d+|\*)$~';

    public function __invoke(Str $name, Str $value): Header
    {
        $value = $value->trim();

        if (
            $name->toLower()->toString() !== 'content-range' ||
            !$value->matches(self::PATTERN)
        ) {
            throw new DomainException;
        }

        $matches = $value->capture(self::PATTERN);
        $length = $matches->get('length')->toString();

        return new ContentRange(
            new ContentRangeValue(
                $matches->get('unit')->toString(),
                (int) $matches->get('first')->toString(),
                (int) $matches->get('last')->toString(),
                $length === '*' ? null : (int) $length,
            ),
        );
    }
}

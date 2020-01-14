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
use Innmind\Immutable\Str;

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

        return new Range(
            new RangeValue(
                $matches->get('unit')->toString(),
                (int) $matches->get('first')->toString(),
                (int) $matches->get('last')->toString(),
            ),
        );
    }
}

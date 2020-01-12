<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\HeaderFactory as HeaderFactoryInterface,
    Header,
    Header\Location,
    Header\LocationValue,
    Exception\DomainException,
};
use Innmind\Url\Url;
use Innmind\Immutable\Str;

final class LocationFactory implements HeaderFactoryInterface
{
    public function __invoke(Str $name, Str $value): Header
    {
        if ($name->toLower()->toString() !== 'location') {
            throw new DomainException;
        }

        return new Location(
            new LocationValue(
                Url::of($value->toString()),
            ),
        );
    }
}

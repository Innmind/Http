<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\HeaderFactoryInterface,
    Header\HeaderInterface,
    Header\Location,
    Header\LocationValue,
    Exception\InvalidArgumentException
};
use Innmind\Url\Url;
use Innmind\Immutable\StringPrimitive as Str;

final class LocationFactory implements HeaderFactoryInterface
{
    public function make(Str $name, Str $value): HeaderInterface
    {
        if ((string) $name->toLower() !== 'location') {
            throw new InvalidArgumentException;
        }

        return new Location(
            new LocationValue(
                Url::fromString((string) $value)
            )
        );
    }
}

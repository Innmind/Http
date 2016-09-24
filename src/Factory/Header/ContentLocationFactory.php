<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\HeaderFactoryInterface,
    Header\HeaderInterface,
    Header\ContentLocation,
    Header\LocationValue
};
use Innmind\Url\Url;
use Innmind\Immutable\StringPrimitive as Str;

final class ContentLocationFactory implements HeaderFactoryInterface
{
    public function make(Str $name, Str $value): HeaderInterface
    {
        return new ContentLocation(
            new LocationValue(
                Url::fromString((string) $value)
            )
        );
    }
}

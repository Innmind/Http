<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\HeaderFactory as HeaderFactoryInterface,
    Header,
    Header\ContentLocation,
    Header\LocationValue,
    Exception\DomainException,
};
use Innmind\Url\Url;
use Innmind\Immutable\Str;

final class ContentLocationFactory implements HeaderFactoryInterface
{
    public function __invoke(Str $name, Str $value): Header
    {
        if ($name->toLower()->toString() !== 'content-location') {
            throw new DomainException($name->toString());
        }

        return new ContentLocation(
            new LocationValue(
                Url::of($value->toString()),
            ),
        );
    }
}

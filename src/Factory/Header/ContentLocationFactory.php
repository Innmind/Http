<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\HeaderFactory,
    Header,
    Header\ContentLocation,
};
use Innmind\Url\Url;
use Innmind\Immutable\{
    Str,
    Maybe,
};

/**
 * @psalm-immutable
 */
final class ContentLocationFactory implements HeaderFactory
{
    #[\Override]
    public function __invoke(Str $name, Str $value): Maybe
    {
        if ($name->toLower()->toString() !== 'content-location') {
            /** @var Maybe<Header> */
            return Maybe::nothing();
        }

        /** @var Maybe<Header> */
        return Url::maybe($value->toString())->map(
            static fn($url) => ContentLocation::of($url),
        );
    }
}

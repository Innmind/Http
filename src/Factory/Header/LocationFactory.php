<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Header;

use Innmind\Http\Header\Location;
use Innmind\Url\Url;
use Innmind\Immutable\{
    Str,
    Maybe,
};

/**
 * @internal
 * @psalm-immutable
 */
final class LocationFactory implements Implementation
{
    #[\Override]
    public function __invoke(Str $value): Maybe
    {
        return Url::maybe($value->toString())->map(
            Location::of(...),
        );
    }
}

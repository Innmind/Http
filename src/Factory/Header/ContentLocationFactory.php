<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Header;

use Innmind\Http\Header\ContentLocation;
use Innmind\Url\Url;
use Innmind\Immutable\{
    Str,
    Maybe,
};

/**
 * @internal
 * @psalm-immutable
 */
final class ContentLocationFactory implements Implementation
{
    #[\Override]
    public function __invoke(Str $value): Maybe
    {
        return Url::maybe($value->toString())->map(
            ContentLocation::of(...),
        );
    }
}

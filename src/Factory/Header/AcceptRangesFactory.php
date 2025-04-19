<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Header;

use Innmind\Http\{
    Header\AcceptRanges,
    Header\AcceptRangesValue,
};
use Innmind\Immutable\{
    Str,
    Maybe,
};

/**
 * @internal
 * @psalm-immutable
 */
final class AcceptRangesFactory implements Implementation
{
    #[\Override]
    public function __invoke(Str $value): Maybe
    {
        return AcceptRangesValue::of($value->toString())->map(
            static fn($value) => new AcceptRanges($value),
        );
    }
}

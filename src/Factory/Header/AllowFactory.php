<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Header;

use Innmind\Http\{
    Header\Allow,
    Header\AllowValue,
};
use Innmind\Immutable\{
    Str,
    Maybe,
    Sequence,
};

/**
 * @internal
 * @psalm-immutable
 */
final class AllowFactory implements Implementation
{
    #[\Override]
    public function __invoke(Str $value): Maybe
    {
        /** @var Sequence<AllowValue> */
        $values = Sequence::of();

        return $value
            ->split(',')
            ->map(static fn($allow) => $allow->trim()->toUpper()->toString())
            ->map(AllowValue::of(...))
            ->sink($values)
            ->maybe(static fn($values, $value) => $value->map($values))
            ->map(static fn($values) => new Allow(...$values->toList()));
    }
}

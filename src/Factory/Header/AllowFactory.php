<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\HeaderFactory,
    Header,
    Header\Allow,
    Header\AllowValue,
};
use Innmind\Immutable\{
    Str,
    Maybe,
    Sequence,
};

/**
 * @psalm-immutable
 */
final class AllowFactory implements HeaderFactory
{
    #[\Override]
    public function __invoke(Str $name, Str $value): Maybe
    {
        if ($name->toLower()->toString() !== 'allow') {
            /** @var Maybe<Header> */
            return Maybe::nothing();
        }

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

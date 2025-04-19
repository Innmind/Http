<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Header;

use Innmind\Http\{
    Header\Age,
    Header\AgeValue,
    Header,
};
use Innmind\Immutable\{
    Str,
    Maybe,
};

/**
 * @internal
 * @psalm-immutable
 */
final class AgeFactory implements Implementation
{
    #[\Override]
    public function __invoke(Str $name, Str $value): Maybe
    {
        if ($name->toLower()->toString() !== 'age') {
            /** @var Maybe<Header> */
            return Maybe::nothing();
        }

        return Maybe::just($value->toString())
            ->filter(\is_numeric(...))
            ->map(static fn($age) => (int) $age)
            ->flatMap(AgeValue::of(...))
            ->map(static fn($value) => new Age($value));
    }
}

<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\HeaderFactory,
    Header\Age,
    Header\AgeValue,
    Header,
};
use Innmind\Immutable\{
    Str,
    Maybe,
};

final class AgeFactory implements HeaderFactory
{
    public function __invoke(Str $name, Str $value): Maybe
    {
        if ($name->toLower()->toString() !== 'age') {
            /** @var Maybe<Header> */
            return Maybe::nothing();
        }

        /** @var Maybe<Header> */
        return Maybe::just($value->toString())
            ->filter(static fn($age) => \is_numeric($age))
            ->map(static fn($age) => (int) $age)
            ->flatMap(static fn($age) => AgeValue::of($age))
            ->map(static fn($value) => new Age($value));
    }
}

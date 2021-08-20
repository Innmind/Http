<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\HeaderFactory,
    Header,
    Header\Value,
    Header\Allow,
};
use Innmind\Immutable\{
    Str,
    Maybe,
};

final class AllowFactory implements HeaderFactory
{
    public function __invoke(Str $name, Str $value): Maybe
    {
        if ($name->toLower()->toString() !== 'allow') {
            /** @var Maybe<Header> */
            return Maybe::nothing();
        }

        $values = $value
            ->split(',')
            ->map(static fn($allow) => $allow->trim()->toUpper()->toString())
            ->toList();

        /** @var Maybe<Header> */
        return Maybe::just(Allow::of(...$values));
    }
}

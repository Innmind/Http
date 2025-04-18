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

        $values = $value
            ->split(',')
            ->map(static fn($allow) => $allow->trim()->toUpper()->toString())
            ->map(static fn($allow) => AllowValue::of($allow));

        if ($values->empty()) {
            /** @var Maybe<Header> */
            return Maybe::just(new Allow);
        }

        /**
         * @psalm-suppress NamedArgumentNotAllowed
         * @psalm-suppress InvalidArgument
         * @var Maybe<Header>
         */
        return Maybe::all(...$values->toList())->map(
            static fn(AllowValue ...$values) => new Allow(...$values),
        );
    }
}

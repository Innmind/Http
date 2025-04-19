<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\HeaderFactory,
    Header,
    Header\Authorization,
    Header\AuthorizationValue,
};
use Innmind\Immutable\{
    Str,
    Maybe,
};

/**
 * @psalm-immutable
 */
final class AuthorizationFactory implements HeaderFactory
{
    private const PATTERN = '~^"?(?<scheme>\w+)"? ?(?<param>.+)?$~';

    #[\Override]
    public function __invoke(Str $name, Str $value): Maybe
    {
        if (
            $name->toLower()->toString() !== 'authorization' ||
            !$value->matches(self::PATTERN)
        ) {
            /** @var Maybe<Header> */
            return Maybe::nothing();
        }

        $matches = $value->capture(self::PATTERN);
        $param = $matches
            ->get('param')
            ->map(static fn($param) => $param->toString())
            ->match(
                static fn($param) => $param,
                static fn() => '',
            );

        return $matches
            ->get('scheme')
            ->map(static fn($scheme) => $scheme->toString())
            ->flatMap(static fn($scheme) => AuthorizationValue::of($scheme, $param))
            ->map(static fn($value) => new Authorization($value));
    }
}

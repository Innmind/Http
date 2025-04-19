<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Header;

use Innmind\Http\{
    Header,
    Header\Authorization,
    Header\AuthorizationValue,
};
use Innmind\Immutable\{
    Str,
    Maybe,
};

/**
 * @internal
 * @psalm-immutable
 */
final class AuthorizationFactory implements Implementation
{
    private const PATTERN = '~^"?(?<scheme>\w+)"? ?(?<param>.+)?$~';

    #[\Override]
    public function __invoke(Str $value): Maybe
    {
        if (!$value->matches(self::PATTERN)) {
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

<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\HeaderFactory as HeaderFactoryInterface,
    Header,
    Header\AuthorizationValue,
    Header\Authorization,
    Exception\DomainException,
};
use Innmind\Immutable\Str;

final class AuthorizationFactory implements HeaderFactoryInterface
{
    private const PATTERN = '~^"?(?<scheme>\w+)"? ?(?<param>.+)?$~';

    public function __invoke(Str $name, Str $value): Header
    {
        if (
            $name->toLower()->toString() !== 'authorization' ||
            !$value->matches(self::PATTERN)
        ) {
            throw new DomainException($name->toString());
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
            ->map(static fn($scheme) => new AuthorizationValue($scheme, $param))
            ->map(static fn($value) => new Authorization($value))
            ->match(
                static fn($authorization) => $authorization,
                static fn() => throw new DomainException,
            );
    }
}

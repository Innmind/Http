<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\HeaderFactoryInterface,
    Header\HeaderInterface,
    Header\AuthorizationValue,
    Header\Authorization,
    Exception\InvalidArgumentException
};
use Innmind\Immutable\Str;

final class AuthorizationFactory implements HeaderFactoryInterface
{
    const PATTERN = '~^"?(?<scheme>\w+)"? ?(?<param>.+)?$~';

    public function make(Str $name, Str $value): HeaderInterface
    {
        if (
            (string) $name->toLower() !== 'authorization' ||
            !$value->matches(self::PATTERN)
        ) {
            throw new InvalidArgumentException;
        }

        $matches = $value->capture(self::PATTERN);

        return new Authorization(
            new AuthorizationValue(
                (string) $matches->get('scheme'),
                $matches->contains('param') ? (string) $matches->get('param') : ''
            )
        );
    }
}

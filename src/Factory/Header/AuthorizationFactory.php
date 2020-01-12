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
            throw new DomainException;
        }

        $matches = $value->capture(self::PATTERN);

        return new Authorization(
            new AuthorizationValue(
                $matches->get('scheme')->toString(),
                $matches->contains('param') ? $matches->get('param')->toString() : '',
            ),
        );
    }
}

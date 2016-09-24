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
use Innmind\Immutable\StringPrimitive as Str;

final class AuthorizationFactory implements HeaderFactoryInterface
{
    public function make(Str $name, Str $value): HeaderInterface
    {
        if ((string) $name->toLower() !== 'authorization') {
            throw new InvalidArgumentException;
        }

        $matches = $value->getMatches('~^"?(?<scheme>\w+)"? ?(?<param>.+)?$~');

        return new Authorization(
            new AuthorizationValue(
                (string) $matches->get('scheme'),
                $matches->hasKey('param') ? (string) $matches->get('param') : ''
            )
        );
    }
}

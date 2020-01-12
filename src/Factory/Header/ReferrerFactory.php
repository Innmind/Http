<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\HeaderFactory as HeaderFactoryInterface,
    Header,
    Header\ReferrerValue,
    Header\Referrer,
    Exception\DomainException,
};
use Innmind\Url\Url;
use Innmind\Immutable\Str;

final class ReferrerFactory implements HeaderFactoryInterface
{
    public function __invoke(Str $name, Str $value): Header
    {
        if ($name->toLower()->toString() !== 'referer') {
            throw new DomainException;
        }

        return new Referrer(
            new ReferrerValue(
                Url::of($value->toString()),
            ),
        );
    }
}

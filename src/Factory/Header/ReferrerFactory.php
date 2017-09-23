<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\HeaderFactory as HeaderFactoryInterface,
    Header,
    Header\ReferrerValue,
    Header\Referrer,
    Exception\DomainException
};
use Innmind\Url\Url;
use Innmind\Immutable\Str;

final class ReferrerFactory implements HeaderFactoryInterface
{
    public function make(Str $name, Str $value): Header
    {
        if ((string) $name->toLower() !== 'referer') {
            throw new DomainException;
        }

        return new Referrer(
            new ReferrerValue(
                Url::fromString((string) $value)
            )
        );
    }
}

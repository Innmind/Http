<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\HeaderFactoryInterface,
    Header\HeaderInterface,
    Header\ReferrerValue,
    Header\Referrer,
    Exception\InvalidArgumentException
};
use Innmind\Url\Url;
use Innmind\Immutable\Str;

final class ReferrerFactory implements HeaderFactoryInterface
{
    public function make(Str $name, Str $value): HeaderInterface
    {
        if ((string) $name->toLower() !== 'referer') {
            throw new InvalidArgumentException;
        }

        return new Referrer(
            new ReferrerValue(
                Url::fromString((string) $value)
            )
        );
    }
}

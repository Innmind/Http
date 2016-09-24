<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\HeaderFactoryInterface,
    Header\HeaderInterface,
    Header\DateValue,
    Header\Expires
};
use Innmind\Immutable\StringPrimitive as Str;

final class ExpiresFactory implements HeaderFactoryInterface
{
    public function make(Str $name, Str $value): HeaderInterface
    {
        return new Expires(
            new DateValue(
                \DateTimeImmutable::createFromFormat(
                    \DateTime::RFC1123,
                    (string) $value
                )
            )
        );
    }
}

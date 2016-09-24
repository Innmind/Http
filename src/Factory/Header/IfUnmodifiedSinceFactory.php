<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\HeaderFactoryInterface,
    Header\HeaderInterface,
    Header\DateValue,
    Header\IfUnmodifiedSince,
    Exception\InvalidArgumentException
};
use Innmind\Immutable\StringPrimitive as Str;

final class IfUnmodifiedSinceFactory implements HeaderFactoryInterface
{
    public function make(Str $name, Str $value): HeaderInterface
    {
        if ((string) $name->toLower() !== 'if-unmodified-since') {
            throw new InvalidArgumentException;
        }

        return new IfUnmodifiedSince(
            new DateValue(
                \DateTimeImmutable::createFromFormat(
                    \DateTime::RFC1123,
                    (string) $value
                )
            )
        );
    }
}

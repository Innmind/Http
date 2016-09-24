<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\HeaderFactoryInterface,
    Header\HeaderInterface,
    Header\DateValue,
    Header\LastModified
};
use Innmind\Immutable\StringPrimitive as Str;

final class LastModifiedFactory implements HeaderFactoryInterface
{
    public function make(Str $name, Str $value): HeaderInterface
    {
        return new LastModified(
            new DateValue(
                \DateTimeImmutable::createFromFormat(
                    \DateTime::RFC1123,
                    (string) $value
                )
            )
        );
    }
}

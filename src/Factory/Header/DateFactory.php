<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\HeaderFactory as HeaderFactoryInterface,
    Header,
    Header\DateValue,
    Header\Date,
    Exception\InvalidArgumentException
};
use Innmind\Immutable\Str;

final class DateFactory implements HeaderFactoryInterface
{
    public function make(Str $name, Str $value): Header
    {
        if ((string) $name->toLower() !== 'date') {
            throw new InvalidArgumentException;
        }

        return new Date(
            new DateValue(
                \DateTimeImmutable::createFromFormat(
                    \DateTime::RFC1123,
                    (string) $value
                )
            )
        );
    }
}

<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\HeaderFactory as HeaderFactoryInterface,
    Header,
    Header\DateValue,
    Header\LastModified,
    Exception\InvalidArgumentException
};
use Innmind\Immutable\Str;

final class LastModifiedFactory implements HeaderFactoryInterface
{
    public function make(Str $name, Str $value): Header
    {
        if ((string) $name->toLower() !== 'last-modified') {
            throw new InvalidArgumentException;
        }

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

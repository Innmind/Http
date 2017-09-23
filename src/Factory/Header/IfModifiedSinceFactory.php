<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\HeaderFactory as HeaderFactoryInterface,
    Header,
    Header\DateValue,
    Header\IfModifiedSince,
    TimeContinuum\Format\Http,
    Exception\DomainException
};
use Innmind\TimeContinuum\{
    PointInTime\Earth\PointInTime,
    Format\ISO8601
};
use Innmind\Immutable\Str;

final class IfModifiedSinceFactory implements HeaderFactoryInterface
{
    public function make(Str $name, Str $value): Header
    {
        if ((string) $name->toLower() !== 'if-modified-since') {
            throw new DomainException;
        }

        return new IfModifiedSince(
            new DateValue(
                new PointInTime(
                    \DateTimeImmutable::createFromFormat((string) new Http, (string) $value)->format((string) new ISO8601)
                )
            )
        );
    }
}

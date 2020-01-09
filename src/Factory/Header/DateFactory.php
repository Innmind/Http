<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\HeaderFactory as HeaderFactoryInterface,
    Header,
    Header\DateValue,
    Header\Date,
    TimeContinuum\Format\Http,
    Exception\DomainException
};
use Innmind\TimeContinuum\{
    PointInTime\Earth\PointInTime,
    Format\ISO8601
};
use Innmind\Immutable\Str;

final class DateFactory implements HeaderFactoryInterface
{
    public function __invoke(Str $name, Str $value): Header
    {
        if ((string) $name->toLower() !== 'date') {
            throw new DomainException;
        }

        return new Date(
            new DateValue(
                new PointInTime(
                    \DateTimeImmutable::createFromFormat((string) new Http, (string) $value)->format((string) new ISO8601)
                )
            )
        );
    }
}

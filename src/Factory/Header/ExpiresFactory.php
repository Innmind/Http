<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\HeaderFactory as HeaderFactoryInterface,
    Header,
    Header\DateValue,
    Header\Expires,
    TimeContinuum\Format\Http,
    Exception\DomainException
};
use Innmind\TimeContinuum\{
    Earth\PointInTime\PointInTime,
    Earth\Format\ISO8601,
};
use Innmind\Immutable\Str;

final class ExpiresFactory implements HeaderFactoryInterface
{
    public function __invoke(Str $name, Str $value): Header
    {
        if ($name->toLower()->toString() !== 'expires') {
            throw new DomainException;
        }

        return new Expires(
            new DateValue(
                new PointInTime(
                    \DateTimeImmutable::createFromFormat(
                        (new Http)->toString(),
                        $value->toString(),
                    )->format((new ISO8601)->toString()),
                ),
            ),
        );
    }
}

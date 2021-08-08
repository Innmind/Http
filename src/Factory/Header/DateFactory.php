<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\HeaderFactory as HeaderFactoryInterface,
    Header,
    Header\DateValue,
    Header\Date,
    TimeContinuum\Format\Http,
    Exception\DomainException,
};
use Innmind\TimeContinuum\Clock;
use Innmind\Immutable\Str;

final class DateFactory implements HeaderFactoryInterface
{
    private Clock $clock;

    public function __construct(Clock $clock)
    {
        $this->clock = $clock;
    }

    public function __invoke(Str $name, Str $value): Header
    {
        if ($name->toLower()->toString() !== 'date') {
            throw new DomainException($name->toString());
        }

        return new Date(
            new DateValue(
                $this->clock->at($value->toString(), new Http)->match(
                    static fn($point) => $point,
                    static fn() => throw new DomainException($name->toString()),
                ),
            ),
        );
    }
}

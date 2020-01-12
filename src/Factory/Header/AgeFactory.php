<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\HeaderFactory as HeaderFactoryInterface,
    Header\Age,
    Header\AgeValue,
    Header,
    Exception\DomainException,
};
use Innmind\Immutable\Str;

final class AgeFactory implements HeaderFactoryInterface
{
    public function __invoke(Str $name, Str $value): Header
    {
        if ($name->toLower()->toString() !== 'age') {
            throw new DomainException;
        }

        return new Age(
            new AgeValue(
                (int) $value->toString(),
            ),
        );
    }
}

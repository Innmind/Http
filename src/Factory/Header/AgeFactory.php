<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\HeaderFactoryInterface,
    Header\Age,
    Header\AgeValue,
    Header\HeaderInterface,
    Exception\InvalidArgumentException
};
use Innmind\Immutable\Str;

final class AgeFactory implements HeaderFactoryInterface
{
    public function make(Str $name, Str $value): HeaderInterface
    {
        if ((string) $name->toLower() !== 'age') {
            throw new InvalidArgumentException;
        }

        return new Age(
            new AgeValue(
                (int) (string) $value
            )
        );
    }
}

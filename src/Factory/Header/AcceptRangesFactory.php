<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\HeaderFactoryInterface,
    Header\AcceptRanges,
    Header\AcceptRangesValue,
    Header\HeaderInterface,
    Exception\InvalidArgumentException
};
use Innmind\Immutable\Str;

final class AcceptRangesFactory implements HeaderFactoryInterface
{
    public function make(Str $name, Str $value): HeaderInterface
    {
        if ((string) $name->toLower() !== 'accept-ranges') {
            throw new InvalidArgumentException;
        }

        return new AcceptRanges(
            new AcceptRangesValue(
                (string) $value
            )
        );
    }
}

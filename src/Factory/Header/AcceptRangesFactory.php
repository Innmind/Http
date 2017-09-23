<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\HeaderFactory as HeaderFactoryInterface,
    Header\AcceptRanges,
    Header\AcceptRangesValue,
    Header,
    Exception\DomainException
};
use Innmind\Immutable\Str;

final class AcceptRangesFactory implements HeaderFactoryInterface
{
    public function make(Str $name, Str $value): Header
    {
        if ((string) $name->toLower() !== 'accept-ranges') {
            throw new DomainException;
        }

        return new AcceptRanges(
            new AcceptRangesValue(
                (string) $value
            )
        );
    }
}

<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\HeaderFactory as HeaderFactoryInterface,
    Header\AcceptRanges,
    Header\AcceptRangesValue,
    Header,
    Exception\DomainException,
};
use Innmind\Immutable\Str;

final class AcceptRangesFactory implements HeaderFactoryInterface
{
    public function __invoke(Str $name, Str $value): Header
    {
        if ($name->toLower()->toString() !== 'accept-ranges') {
            throw new DomainException($name->toString());
        }

        return new AcceptRanges(
            new AcceptRangesValue(
                $value->toString(),
            ),
        );
    }
}

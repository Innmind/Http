<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\HeaderFactory,
    Header\AcceptRanges,
    Header,
};
use Innmind\Immutable\{
    Str,
    Maybe,
};

final class AcceptRangesFactory implements HeaderFactory
{
    public function __invoke(Str $name, Str $value): Maybe
    {
        if ($name->toLower()->toString() !== 'accept-ranges') {
            /** @var Maybe<Header> */
            return Maybe::nothing();
        }

        /** @var Maybe<Header> */
        return Maybe::just(AcceptRanges::of($value->toString()));
    }
}

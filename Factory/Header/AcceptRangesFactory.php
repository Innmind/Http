<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\HeaderFactoryInterface,
    Header\HeaderInterface,
    Header\AcceptRangesValue,
    Header\AcceptRanges
};
use Innmind\Immutable\StringPrimitive as Str;

final class AcceptRangesFactory implements HeaderFactoryInterface
{
    public function make(Str $name, Str $value): HeaderInterface
    {
        return new AcceptRanges(
            new AcceptRangesValue(
                (string) $value
            )
        );
    }
}

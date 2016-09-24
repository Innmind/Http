<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\HeaderFactoryInterface,
    Header\ContentLength,
    Header\ContentLengthValue,
    Header\HeaderInterface
};
use Innmind\Immutable\StringPrimitive as Str;

final class ContentLengthFactory implements HeaderFactoryInterface
{
    public function make(Str $name, Str $value): HeaderInterface
    {
        return new ContentLength(
            new ContentLengthValue(
                (int) (string) $value
            )
        );
    }
}

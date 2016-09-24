<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\HeaderFactoryInterface,
    Header\HeaderInterface,
    Header\ContentEncoding,
    Header\ContentEncodingValue
};
use Innmind\Immutable\StringPrimitive as Str;

final class ContentEncodingFactory implements HeaderFactoryInterface
{
    public function make(Str $name, Str $value): HeaderInterface
    {
        return new ContentEncoding(
            new ContentEncodingValue(
                (string) $value
            )
        );
    }
}

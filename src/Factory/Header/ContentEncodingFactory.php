<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\HeaderFactory as HeaderFactoryInterface,
    Header,
    Header\ContentEncoding,
    Header\ContentEncodingValue,
    Exception\InvalidArgumentException
};
use Innmind\Immutable\Str;

final class ContentEncodingFactory implements HeaderFactoryInterface
{
    public function make(Str $name, Str $value): Header
    {
        if ((string) $name->toLower() !== 'content-encoding') {
            throw new InvalidArgumentException;
        }

        return new ContentEncoding(
            new ContentEncodingValue(
                (string) $value
            )
        );
    }
}

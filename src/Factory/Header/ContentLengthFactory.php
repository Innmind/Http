<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\HeaderFactoryInterface,
    Header\ContentLength,
    Header\ContentLengthValue,
    Header\HeaderInterface,
    Exception\InvalidArgumentException
};
use Innmind\Immutable\StringPrimitive as Str;

final class ContentLengthFactory implements HeaderFactoryInterface
{
    public function make(Str $name, Str $value): HeaderInterface
    {
        if ((string) $name->toLower() !== 'content-length') {
            throw new InvalidArgumentException;
        }

        return new ContentLength(
            new ContentLengthValue(
                (int) (string) $value
            )
        );
    }
}

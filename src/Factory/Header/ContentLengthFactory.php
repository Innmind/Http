<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\HeaderFactory as HeaderFactoryInterface,
    Header\ContentLength,
    Header\ContentLengthValue,
    Header,
    Exception\InvalidArgumentException
};
use Innmind\Immutable\Str;

final class ContentLengthFactory implements HeaderFactoryInterface
{
    public function make(Str $name, Str $value): Header
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

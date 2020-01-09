<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\HeaderFactory as HeaderFactoryInterface,
    Header\ContentLength,
    Header\ContentLengthValue,
    Header,
    Exception\DomainException
};
use Innmind\Immutable\Str;

final class ContentLengthFactory implements HeaderFactoryInterface
{
    public function __invoke(Str $name, Str $value): Header
    {
        if ((string) $name->toLower() !== 'content-length') {
            throw new DomainException;
        }

        return new ContentLength(
            new ContentLengthValue(
                (int) (string) $value
            )
        );
    }
}

<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\HeaderFactory as HeaderFactoryInterface,
    Header\ContentLength,
    Header\ContentLengthValue,
    Header,
    Exception\DomainException,
};
use Innmind\Immutable\Str;

final class ContentLengthFactory implements HeaderFactoryInterface
{
    public function __invoke(Str $name, Str $value): Header
    {
        if ($name->toLower()->toString() !== 'content-length') {
            throw new DomainException($name->toString());
        }

        return new ContentLength(
            new ContentLengthValue(
                (int) $value->toString(),
            ),
        );
    }
}

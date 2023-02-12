<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\HeaderFactory,
    Header,
    Header\ContentType,
    Header\ContentTypeValue,
    Header\Parameter,
};
use Innmind\MediaType\MediaType;
use Innmind\Immutable\{
    Str,
    Maybe,
};

/**
 * @psalm-immutable
 */
final class ContentTypeFactory implements HeaderFactory
{
    public function __invoke(Str $name, Str $value): Maybe
    {
        if ($name->toLower()->toString() !== 'content-type') {
            /** @var Maybe<Header> */
            return Maybe::nothing();
        }

        /** @var Maybe<Header> */
        return MediaType::maybe($value->toString())
            ->flatMap(static fn($mediaType) => ContentTypeValue::of(
                $mediaType->topLevel(),
                $mediaType->subType(),
                ...$mediaType
                    ->parameters()
                    ->map(static fn($param) => new Parameter\Parameter(
                        $param->name(),
                        $param->value(),
                    ))
                    ->toList(),
            ))
            ->map(static fn($value) => new ContentType($value));
    }
}

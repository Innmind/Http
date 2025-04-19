<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Header;

use Innmind\Http\{
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
 * @internal
 * @psalm-immutable
 */
final class ContentTypeFactory implements Implementation
{
    #[\Override]
    public function __invoke(Str $name, Str $value): Maybe
    {
        if ($name->toLower()->toString() !== 'content-type') {
            /** @var Maybe<Header> */
            return Maybe::nothing();
        }

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

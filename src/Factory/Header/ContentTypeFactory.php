<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\HeaderFactory as HeaderFactoryInterface,
    Header,
    Header\ContentType,
    Header\ContentTypeValue,
    Header\Parameter,
    Exception\DomainException,
};
use Innmind\Immutable\{
    Str,
    Maybe,
};

final class ContentTypeFactory implements HeaderFactoryInterface
{
    private const PATTERN = '~(?<type>[\w*]+)/(?<subType>[\w*]+)(?<params>(; ?\w+=\"?[\w\-.]+\"?)+)?~';

    public function __invoke(Str $name, Str $value): Header
    {
        if (
            $name->toLower()->toString() !== 'content-type' ||
            !$value->matches(self::PATTERN)
        ) {
            throw new DomainException($name->toString());
        }

        $matches = $value->capture(self::PATTERN);

        return Maybe::all(
            $matches->get('type'),
            $matches->get('subType'),
            $matches->get('params')->otherwise(static fn() => Maybe::just(Str::of(''))),
        )
            ->map(fn(Str $type, Str $subType, Str $params) => new ContentTypeValue(
                $type->toString(),
                $subType->toString(),
                ...$this->buildParams($params),
            ))
            ->map(static fn($value) => new ContentType($value))
            ->match(
                static fn($contentType) => $contentType,
                static fn() => throw new DomainException,
            );
    }

    /**
     * @return list<Parameter>
     */
    private function buildParams(Str $params): array
    {
        /** @var list<Parameter> */
        return $params
            ->split(';')
            ->filter(static function(Str $value): bool {
                return !$value->trim()->empty();
            })
            ->reduce(
                [],
                static function(array $carry, Str $value): array {
                    $matches = $value->capture('~(?<key>\w+)=\"?(?<value>[\w\-.]+)\"?~');
                    $carry[] = Maybe::all($matches->get('key'), $matches->get('value'))
                        ->map(static fn(Str $key, Str $value) => new Parameter\Parameter(
                            $key->toString(),
                            $value->toString(),
                        ))
                        ->match(
                            static fn($parameter) => $parameter,
                            static fn() => throw new DomainException,
                        );

                    return $carry;
                },
            );
    }
}

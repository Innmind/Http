<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\HeaderFactory,
    Header,
    Header\ContentType,
    Header\Parameter,
};
use Innmind\Immutable\{
    Str,
    Maybe,
};

final class ContentTypeFactory implements HeaderFactory
{
    private const PATTERN = '~(?<type>[\w*]+)/(?<subType>[\w*]+)(?<params>(; ?\w+=\"?[\w\-.]+\"?)+)?~';

    public function __invoke(Str $name, Str $value): Maybe
    {
        if (
            $name->toLower()->toString() !== 'content-type' ||
            !$value->matches(self::PATTERN)
        ) {
            /** @var Maybe<Header> */
            return Maybe::nothing();
        }

        $matches = $value->capture(self::PATTERN);
        $params = $this->buildParams($matches->get('params')->match(
            static fn($params) => $params,
            static fn() => Str::of(''),
        ));

        /** @var Maybe<Header> */
        return Maybe::all(
            $matches->get('type'),
            $matches->get('subType'),
            ...$params,
        )
            ->map(static fn(Str $type, Str $subType, Parameter ...$params) => ContentType::of(
                $type->toString(),
                $subType->toString(),
                ...$params,
            ));
    }

    /**
     * @return list<Maybe<Parameter\Parameter>>
     */
    private function buildParams(Str $params): array
    {
        return $params
            ->split(';')
            ->filter(static function(Str $value): bool {
                return !$value->trim()->empty();
            })
            ->map(static function(Str $value) {
                $matches = $value->capture('~(?<key>\w+)=\"?(?<value>[\w\-.]+)\"?~');

                return Maybe::all($matches->get('key'), $matches->get('value'))
                    ->map(static fn(Str $key, Str $value) => new Parameter\Parameter(
                        $key->toString(),
                        $value->toString(),
                    ));
            })
            ->toList();
    }
}

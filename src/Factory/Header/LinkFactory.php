<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\HeaderFactory,
    Header,
    Header\LinkValue,
    Header\Link,
    Header\Parameter,
};
use Innmind\Url\Url;
use Innmind\Immutable\{
    Str,
    Map,
    Maybe,
    Sequence,
};

/**
 * @psalm-immutable
 */
final class LinkFactory implements HeaderFactory
{
    private const PATTERN = '~^<(?<url>\S+)>(?<params>(; ?\w+=\"?[ \t!#$%&\\\'()*+\-.\/\d:<=>?@A-z{|}\~]+\"?)+)?$~';

    #[\Override]
    public function __invoke(Str $name, Str $value): Maybe
    {
        if ($name->toLower()->toString() !== 'link') {
            /** @var Maybe<Header> */
            return Maybe::nothing();
        }

        /** @var Sequence<LinkValue> */
        $values = Sequence::of();

        return $value
            ->split(',')
            ->map(static fn($link) => $link->trim())
            ->map(function(Str $link) {
                $matches = $link->capture(self::PATTERN);
                $params = $this->buildParams(
                    $matches->get('params')->match(
                        static fn($params) => $params,
                        static fn() => Str::of(''),
                    ),
                );
                $url = $matches
                    ->get('url')
                    ->flatMap(static fn($url) => Url::maybe($url->toString()));

                /**
                 * @psalm-suppress MixedArgumentTypeCoercion
                 * @psalm-suppress MixedArgument
                 */
                return Maybe::all($url, $params)->flatMap(
                    static fn(Url $url, Map $params) => LinkValue::of(
                        $url,
                        $params->get('rel')->match(
                            static fn(Parameter $rel) => $rel->value(),
                            static fn() => null,
                        ),
                        ...$params
                            ->remove('rel')
                            ->values()
                            ->toList(),
                    ),
                );
            })
            ->sink($values)
            ->maybe(static fn($values, $value) => $value->map($values))
            ->map(static fn($values) => new Link(...$values->toList()));
    }

    /**
     * @return Maybe<Map<string, Parameter\Parameter>>
     */
    private function buildParams(Str $params): Maybe
    {
        $params = $params
            ->split(';')
            ->filter(static fn(Str $value) => !$value->trim()->empty())
            ->map(static function(Str $value) {
                $matches = $value->capture('~(?<key>\w+)=\"?(?<value>[ \t!#$%&\\\'()*+\-.\/\d:<=>?@A-z{|}\~]+)\"?~');

                return Maybe::all($matches->get('key'), $matches->get('value'))
                    ->map(static fn(Str $key, Str $value) => new Parameter\Parameter(
                        $key->toString(),
                        $value->toString(),
                    ))
                    ->map(static fn($parameter) => [$parameter->name(), $parameter]);
            });

        if ($params->empty()) {
            /** @var Maybe<Map<string, Parameter\Parameter>> */
            return Maybe::just(Map::of());
        }

        /**
         * @psalm-suppress MixedArgumentTypeCoercion
         * @psalm-suppress InvalidArgument
         * @var Maybe<Map<string, Parameter\Parameter>>
         */
        return Maybe::all(...$params->toList())->map(
            static fn(array ...$params) => Map::of(...$params),
        );
    }
}

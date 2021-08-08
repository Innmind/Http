<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\HeaderFactory as HeaderFactoryInterface,
    Header,
    Header\Value,
    Header\LinkValue,
    Header\Link,
    Header\Parameter,
    Exception\DomainException
};
use Innmind\Url\Url;
use Innmind\Immutable\{
    Str,
    Map,
    Maybe,
};

final class LinkFactory implements HeaderFactoryInterface
{
    private const PATTERN = '~^<(?<url>\S+)>(?<params>(; ?\w+=\"?[ \t!#$%&\\\'()*+\-.\/\d:<=>?@A-z{|}\~]+\"?)+)?$~';

    public function __invoke(Str $name, Str $value): Header
    {
        if ($name->toLower()->toString() !== 'link') {
            throw new DomainException($name->toString());
        }

        $values = $value
            ->split(',')
            ->map(static function(Str $link): Str {
                return $link->trim();
            });
        $_ = $values->foreach(static function(Str $link): void {
            if (!$link->matches(self::PATTERN)) {
                throw new DomainException($link->toString());
            }
        });

        /** @var list<LinkValue> */
        $links = $values->reduce(
            [],
            function(array $carry, Str $link): array {
                $matches = $link->capture(self::PATTERN);
                $params = $this->buildParams(
                    $matches->get('params')->match(
                        static fn($params) => $params,
                        static fn() => Str::of(''),
                    ),
                );
                $carry[] = new LinkValue(
                    $matches->get('url')->match(
                        static fn($url) => Url::of($url->toString()),
                        static fn() => throw new DomainException,
                    ),
                    $params->get('rel')->match(
                        static fn($rel) => $rel->value(),
                        static fn() => null,
                    ),
                    ...$params
                        ->remove('rel')
                        ->values()
                        ->toList(),
                );

                return $carry;
            },
        );

        return new Link(...$links);
    }

    /**
     * @return Map<string, Parameter>
     */
    private function buildParams(Str $params): Map
    {
        /** @var Map<string, Parameter> */
        return $params
            ->split(';')
            ->filter(static function(Str $value): bool {
                return !$value->trim()->empty();
            })
            ->reduce(
                Map::of(),
                static function(Map $carry, Str $value): Map {
                    $matches = $value->capture('~(?<key>\w+)=\"?(?<value>[ \t!#$%&\\\'()*+\-.\/\d:<=>?@A-z{|}\~]+)\"?~');

                    return Maybe::all($matches->get('key'), $matches->get('value'))
                        ->map(static fn(Str $key, Str $value) => new Parameter\Parameter(
                            $key->toString(),
                            $value->toString(),
                        ))
                        ->match(
                            static fn($parameter) => ($carry)(
                                $parameter->name(),
                                $parameter,
                            ),
                            static fn() => throw new DomainException,
                        );
                },
            );
    }
}

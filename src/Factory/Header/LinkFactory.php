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
};
use function Innmind\Immutable\unwrap;

final class LinkFactory implements HeaderFactoryInterface
{
    private const PATTERN = '~^<(?<url>\S+)>(?<params>(; ?\w+=\"?[ \t!#$%&\\\'()*+\-.\/\d:<=>?@A-z{|}\~]+\"?)+)?$~';

    public function __invoke(Str $name, Str $value): Header
    {
        if ($name->toLower()->toString() !== 'link') {
            throw new DomainException;
        }

        $values = $value
            ->split(',')
            ->map(static function(Str $link): Str {
                return $link->trim();
            });
        $values->foreach(static function(Str $link): void {
            if (!$link->matches(self::PATTERN)) {
                throw new DomainException;
            }
        });

        return new Link(
            ...$values->reduce(
                [],
                function(array $carry, Str $link): array {
                    $matches = $link->capture(self::PATTERN);
                    $params = $this->buildParams(
                        $matches->contains('params') ? $matches->get('params') : Str::of('')
                    );
                    $carry[] = new LinkValue(
                        Url::of($matches->get('url')->toString()),
                        $params->contains('rel') ?
                            $params->get('rel')->value() : null,
                        ...unwrap($params
                            ->remove('rel')
                            ->values()),
                    );

                    return $carry;
                },
            ),
        );
    }

    private function buildParams(Str $params): Map
    {
        return $params
            ->split(';')
            ->filter(static function(Str $value): bool {
                return $value->trim()->length() > 0;
            })
            ->reduce(
                Map::of('string', Parameter::class),
                static function(Map $carry, Str $value): Map {
                    $matches = $value->capture('~(?<key>\w+)=\"?(?<value>[ \t!#$%&\\\'()*+\-.\/\d:<=>?@A-z{|}\~]+)\"?~');

                    return $carry->put(
                        $matches->get('key')->toString(),
                        new Parameter\Parameter(
                            $matches->get('key')->toString(),
                            $matches->get('value')->toString(),
                        ),
                    );
                },
            );
    }
}

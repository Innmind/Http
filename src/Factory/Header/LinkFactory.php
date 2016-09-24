<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\HeaderFactoryInterface,
    Header\HeaderInterface,
    Header\HeaderValueInterface,
    Header\LinkValue,
    Header\Link,
    Header\ParameterInterface,
    Header\Parameter
};
use Innmind\Url\Url;
use Innmind\Immutable\{
    StringPrimitive as Str,
    Set,
    MapInterface,
    Map
};

final class LinkFactory implements HeaderFactoryInterface
{
    public function make(Str $name, Str $value): HeaderInterface
    {
        $links = new Set(HeaderValueInterface::class);

        foreach ($value->split(',') as $link) {
            $matches = $link->trim()->getMatches(
                '~^<(?<url>\S+)>(?<params>(; ?\w+=\"?[\w\-.]+\"?)+)?$~'
            );
            $params = $this->buildParams(
                $matches->hasKey('params') ? $matches->get('params') : new Str('')
            );

            $links = $links->add(
                new LinkValue(
                    Url::fromString((string) $matches->get('url')),
                    $params->contains('rel') ?
                        $params->get('rel')->value() : 'related',
                    $params->contains('rel') ?
                        $params->remove('rel') : $params
                )
            );
        }

        return new Link($links);
    }

    private function buildParams(Str $params): MapInterface
    {
        $params = $params->split(';');
        $map = new Map('string', ParameterInterface::class);

        foreach ($params as $value) {
            if ($value->trim()->length() === 0) {
                continue;
            }

            $matches = $value->getMatches('~(?<key>\w+)=\"?(?<value>[\w\-.]+)\"?~');
            $map = $map->put(
                (string) $matches->get('key'),
                new Parameter(
                    (string) $matches->get('key'),
                    (string) $matches->get('value')
                )
            );
        }

        return $map;
    }
}

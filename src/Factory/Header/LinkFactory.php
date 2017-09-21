<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\HeaderFactory as HeaderFactoryInterface,
    Header,
    Header\HeaderValue,
    Header\LinkValue,
    Header\Link,
    Header\Parameter,
    Exception\InvalidArgumentException
};
use Innmind\Url\Url;
use Innmind\Immutable\{
    Str,
    Set,
    MapInterface,
    Map
};

final class LinkFactory implements HeaderFactoryInterface
{
    const PATTERN = '~^<(?<url>\S+)>(?<params>(; ?\w+=\"?[ \t!#$%&\\\'()*+\-.\/\d:<=>?@A-z{|}\~]+\"?)+)?$~';

    public function make(Str $name, Str $value): Header
    {
        if ((string) $name->toLower() !== 'link') {
            throw new InvalidArgumentException;
        }

        $links = new Set(HeaderValue::class);

        foreach ($value->split(',') as $link) {
            $link = $link->trim();

            if (!$link->matches(self::PATTERN)) {
                throw new InvalidArgumentException;
            }

            $matches = $link->capture(self::PATTERN);
            $params = $this->buildParams(
                $matches->contains('params') ? $matches->get('params') : new Str('')
            );

            $links = $links->add(
                new LinkValue(
                    Url::fromString((string) $matches->get('url')),
                    $params->contains('rel') ?
                        $params->get('rel')->value() : null,
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
        $map = new Map('string', Parameter::class);

        foreach ($params as $value) {
            if ($value->trim()->length() === 0) {
                continue;
            }

            $matches = $value->capture('~(?<key>\w+)=\"?(?<value>[ \t!#$%&\\\'()*+\-.\/\d:<=>?@A-z{|}\~]+)\"?~');
            $map = $map->put(
                (string) $matches->get('key'),
                new Parameter\Parameter(
                    (string) $matches->get('key'),
                    (string) $matches->get('value')
                )
            );
        }

        return $map;
    }
}

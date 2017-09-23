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
    Set,
    Map
};

final class LinkFactory implements HeaderFactoryInterface
{
    const PATTERN = '~^<(?<url>\S+)>(?<params>(; ?\w+=\"?[ \t!#$%&\\\'()*+\-.\/\d:<=>?@A-z{|}\~]+\"?)+)?$~';

    public function make(Str $name, Str $value): Header
    {
        if ((string) $name->toLower() !== 'link') {
            throw new DomainException;
        }

        return new Link(
            ...$value
                ->split(',')
                ->map(static function(Str $link): Str {
                    return $link->trim();
                })
                ->foreach(static function(Str $link): void {
                    if (!$link->matches(self::PATTERN)) {
                        throw new DomainException;
                    }
                })
                ->reduce(
                    new Set(Value::class),
                    function(Set $carry, Str $link): Set {
                        $matches = $link->capture(self::PATTERN);
                        $params = $this->buildParams(
                            $matches->contains('params') ? $matches->get('params') : new Str('')
                        );

                        return $carry->add(
                            new LinkValue(
                                Url::fromString((string) $matches->get('url')),
                                $params->contains('rel') ?
                                    $params->get('rel')->value() : null,
                                $params->contains('rel') ?
                                    $params->remove('rel') : $params
                            )
                        );
                    }
                )
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
                new Map('string', Parameter::class),
                static function(Map $carry, Str $value): Map {
                    $matches = $value->capture('~(?<key>\w+)=\"?(?<value>[ \t!#$%&\\\'()*+\-.\/\d:<=>?@A-z{|}\~]+)\"?~');

                    return $carry->put(
                        (string) $matches->get('key'),
                        new Parameter\Parameter(
                            (string) $matches->get('key'),
                            (string) $matches->get('value')
                        )
                    );
                }
            );
    }
}

<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\HeaderFactoryInterface,
    Header\HeaderInterface,
    Header\HeaderValueInterface,
    Header\AcceptValue,
    Header\Accept,
    Header\ParameterInterface,
    Header\Parameter
};
use Innmind\Immutable\{
    StringPrimitive as Str,
    Set,
    MapInterface,
    Map
};

final class AcceptFactory implements HeaderFactoryInterface
{
    public function make(Str $name, Str $value): HeaderInterface
    {
        $values = new Set(HeaderValueInterface::class);

        foreach ($value->split(',') as $accept) {
            $matches = $accept->getMatches(
                '~(?<type>[\w*]+)/(?<subType>[\w*]+)(?<params>(; ?\w+=\"?[\w\-.]+\"?)+)?~'
            );

            $values = $values->add(
                new AcceptValue(
                    (string) $matches->get('type'),
                    (string) $matches->get('subType'),
                    $this->buildParams(
                        $matches->hasKey('params') ?
                            $matches->get('params') : new Str('')
                    )
                )
            );
        }

        return new Accept($values);
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

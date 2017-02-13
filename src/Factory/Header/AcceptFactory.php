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
    Header\Parameter,
    Exception\InvalidArgumentException
};
use Innmind\Immutable\{
    Str,
    Set,
    MapInterface,
    Map
};

final class AcceptFactory implements HeaderFactoryInterface
{
    const PATTERN = '~(?<type>[\w*]+)/(?<subType>[\w*]+)(?<params>(; ?\w+=\"?[\w\-.]+\"?)+)?~';

    public function make(Str $name, Str $value): HeaderInterface
    {
        if ((string) $name->toLower() !== 'accept') {
            throw new InvalidArgumentException;
        }

        $values = new Set(HeaderValueInterface::class);

        foreach ($value->split(',') as $accept) {
            if (!$accept->matches(self::PATTERN)) {
                throw new InvalidArgumentException;
            }

            $matches = $accept->getMatches(self::PATTERN);

            $values = $values->add(
                new AcceptValue(
                    (string) $matches->get('type'),
                    (string) $matches->get('subType'),
                    $this->buildParams(
                        $matches->contains('params') ?
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

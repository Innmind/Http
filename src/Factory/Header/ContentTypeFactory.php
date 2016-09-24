<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\HeaderFactoryInterface,
    Header\HeaderInterface,
    Header\ContentType,
    Header\ContentTypeValue,
    Header\ParameterInterface,
    Header\Parameter,
    Exception\InvalidArgumentException
};
use Innmind\Immutable\{
    StringPrimitive as Str,
    Map,
    MapInterface
};

final class ContentTypeFactory implements HeaderFactoryInterface
{
    public function make(Str $name, Str $value): HeaderInterface
    {
        if ((string) $name->toLower() !== 'content-type') {
            throw new InvalidArgumentException;
        }

        $matches = $value->getMatches(
            '~(?<type>[\w*]+)/(?<subType>[\w*]+)(?<params>(; ?\w+=\"?[\w\-.]+\"?)+)?~'
        );

        return new ContentType(
            new ContentTypeValue(
                (string) $matches->get('type'),
                (string) $matches->get('subType'),
                $this->buildParams(
                    $matches->hasKey('params') ?
                        $matches->get('params') : new Str('')
                )
            )
        );
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

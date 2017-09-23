<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\HeaderFactory as HeaderFactoryInterface,
    Header,
    Header\ContentType,
    Header\ContentTypeValue,
    Header\Parameter,
    Exception\DomainException
};
use Innmind\Immutable\{
    Str,
    Map
};

final class ContentTypeFactory implements HeaderFactoryInterface
{
    const PATTERN = '~(?<type>[\w*]+)/(?<subType>[\w*]+)(?<params>(; ?\w+=\"?[\w\-.]+\"?)+)?~';

    public function make(Str $name, Str $value): Header
    {
        if (
            (string) $name->toLower() !== 'content-type' ||
            !$value->matches(self::PATTERN)
        ) {
            throw new DomainException;
        }

        $matches = $value->capture(self::PATTERN);

        return new ContentType(
            new ContentTypeValue(
                (string) $matches->get('type'),
                (string) $matches->get('subType'),
                $this->buildParams(
                    $matches->contains('params') ?
                        $matches->get('params') : new Str('')
                )
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
                    $matches = $value->capture('~(?<key>\w+)=\"?(?<value>[\w\-.]+)\"?~');

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

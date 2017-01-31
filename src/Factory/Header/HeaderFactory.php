<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\HeaderFactoryInterface,
    Header\HeaderInterface,
    Header\HeaderValueInterface,
    Header\Header,
    Header\HeaderValue
};
use Innmind\Immutable\{
    StringPrimitive as Str,
    Set
};

final class HeaderFactory implements HeaderFactoryInterface
{
    public function make(Str $name, Str $value): HeaderInterface
    {
        return new Header(
            (string) $name,
            $value
                ->split(',')
                ->map(function(Str $value): Str {
                    return $value->trim();
                })
                ->reduce(
                    function(Set $carry, Str $value): Set {
                        return $carry->add(
                            new HeaderValue((string) $value)
                        );
                    },
                    new Set(HeaderValueInterface::class)
                )
        );
    }
}

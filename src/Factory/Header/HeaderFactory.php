<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\HeaderFactory as HeaderFactoryInterface,
    Header,
    Header\Value
};
use Innmind\Immutable\{
    Str,
    Set
};

final class HeaderFactory implements HeaderFactoryInterface
{
    public function make(Str $name, Str $value): Header
    {
        return new Header\Header(
            (string) $name,
            $value
                ->split(',')
                ->map(function(Str $value): Str {
                    return $value->trim();
                })
                ->reduce(
                    new Set(Value::class),
                    function(Set $carry, Str $value): Set {
                        return $carry->add(
                            new Value\Value((string) $value)
                        );
                    }
                )
        );
    }
}

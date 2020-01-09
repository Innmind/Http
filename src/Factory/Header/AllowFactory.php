<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\HeaderFactory as HeaderFactoryInterface,
    Header,
    Header\Value,
    Header\Allow,
    Header\AllowValue,
    Exception\DomainException
};
use Innmind\Immutable\{
    Str,
    Set
};

final class AllowFactory implements HeaderFactoryInterface
{
    public function __invoke(Str $name, Str $value): Header
    {
        if ((string) $name->toLower() !== 'allow') {
            throw new DomainException;
        }

        return new Allow(
            ...$value
                ->split(',')
                ->reduce(
                    new Set(Value::class),
                    static function(Set $carry, Str $allow): Set {
                        return $carry->add(new AllowValue(
                            (string) $allow->trim()->toUpper()
                        ));
                    }
                )
        );
    }
}

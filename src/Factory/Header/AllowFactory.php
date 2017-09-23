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
    public function make(Str $name, Str $value): Header
    {
        if ((string) $name->toLower() !== 'allow') {
            throw new DomainException;
        }

        $values = new Set(Value::class);

        foreach ($value->split(',') as $allow) {
            $values = $values->add(
                new AllowValue(
                    (string) $allow->trim()->toUpper()
                )
            );
        }

        return new Allow($values);
    }
}

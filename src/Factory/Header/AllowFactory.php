<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\HeaderFactory as HeaderFactoryInterface,
    Header,
    Header\Value,
    Header\Allow,
    Header\AllowValue,
    Exception\DomainException,
};
use Innmind\Immutable\Str;

final class AllowFactory implements HeaderFactoryInterface
{
    public function __invoke(Str $name, Str $value): Header
    {
        if ($name->toLower()->toString() !== 'allow') {
            throw new DomainException;
        }

        return new Allow(
            ...$value
                ->split(',')
                ->reduce(
                    [],
                    static function(array $carry, Str $allow): array {
                        $carry[] = new AllowValue(
                            $allow->trim()->toUpper()->toString(),
                        );

                        return $carry;
                    },
                ),
        );
    }
}

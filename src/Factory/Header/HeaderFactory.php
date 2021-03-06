<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\HeaderFactory as HeaderFactoryInterface,
    Header,
    Header\Value,
};
use Innmind\Immutable\Str;

final class HeaderFactory implements HeaderFactoryInterface
{
    public function __invoke(Str $name, Str $value): Header
    {
        /** @var list<Value\Value> */
        $values = $value
            ->split(',')
            ->map(static function(Str $value): Str {
                return $value->trim();
            })
            ->reduce(
                [],
                static function(array $carry, Str $value): array {
                    $carry[] = new Value\Value($value->toString());

                    return $carry;
                },
            );

        return new Header\Header(
            $name->toString(),
            ...$values,
        );
    }
}

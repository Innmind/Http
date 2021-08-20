<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Header;

use Innmind\Http\{
    Header,
    Header\Value,
};
use Innmind\Immutable\{
    Str,
    Maybe,
};

final class HeaderFactory
{
    public function __invoke(Str $name, Str $value): Header
    {
        $values = $value
            ->split(',')
            ->map(static function(Str $value): Str {
                return $value->trim();
            })
            ->map(static fn($value) => new Value\Value($value->toString()))
            ->toList();

        return new Header\Header(
            $name->toString(),
            ...$values,
        );
    }
}

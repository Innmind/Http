<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory;

use Innmind\Http\Header;
use Innmind\Immutable\{
    Str,
    Maybe,
};

interface HeaderFactory
{
    /**
     * @return Maybe<Header>
     */
    public function __invoke(Str $name, Str $value): Maybe;
}

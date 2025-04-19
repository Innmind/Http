<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Header;

use Innmind\Http\Header;
use Innmind\Immutable\{
    Str,
    Maybe,
};

/**
 * @internal
 * @psalm-immutable
 */
interface Implementation
{
    /**
     * @return Maybe<Header>
     */
    public function __invoke(Str $name, Str $value): Maybe;
}

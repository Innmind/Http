<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\Header\HeaderFactory as DefaultFactory,
    Header,
};
use Innmind\Immutable\Str;

/**
 * @internal
 * @psalm-immutable
 */
final class TryFactory
{
    private Implementation $try;
    /** @var callable(Str, Str): Header */
    private $fallback;

    /**
     * @param ?callable(Str, Str): Header $fallback
     */
    public function __construct(Implementation $try, ?callable $fallback = null)
    {
        $default = new DefaultFactory;
        $this->try = $try;
        $this->fallback = $fallback ?? static fn(Str $name, Str $value): Header => $default($name, $value);
    }

    public function __invoke(Str $name, Str $value): Header
    {
        return ($this->try)($name, $value)->match(
            static fn($header) => $header,
            fn() => ($this->fallback)($name, $value),
        );
    }
}

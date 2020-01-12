<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\HeaderFactory as HeaderFactoryInterface,
    Header,
};
use Innmind\Immutable\Str;

final class TryFactory implements HeaderFactoryInterface
{
    private HeaderFactoryInterface $try;
    private HeaderFactoryInterface $fallback;

    public function __construct(
        HeaderFactoryInterface $try,
        HeaderFactoryInterface $fallback
    ) {
        $this->try = $try;
        $this->fallback = $fallback;
    }

    public function __invoke(Str $name, Str $value): Header
    {
        try {
            return ($this->try)($name, $value);
        } catch (\Throwable $e) {
            return ($this->fallback)($name, $value);
        }
    }
}

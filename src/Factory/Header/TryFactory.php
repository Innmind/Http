<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\HeaderFactoryInterface,
    Header\HeaderInterface
};
use Innmind\Immutable\Str;

final class TryFactory implements HeaderFactoryInterface
{
    private $try;
    private $fallback;

    public function __construct(
        HeaderFactoryInterface $try,
        HeaderFactoryInterface $fallback
    ) {
        $this->try = $try;
        $this->fallback = $fallback;
    }

    public function make(Str $name, Str $value): HeaderInterface
    {
        try {
            return $this->try->make($name, $value);
        } catch (\Throwable $e) {
            return $this->fallback->make($name, $value);
        }
    }
}

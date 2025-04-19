<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Header;

use Innmind\Http\Header;
use Innmind\TimeContinuum\Clock;
use Innmind\Immutable\Str;

/**
 * @internal
 * @psalm-immutable
 */
final class Factory
{
    private Clock $clock;
    private HeaderFactory $fallback;

    private function __construct(Clock $clock)
    {
        $this->clock = $clock;
        $this->fallback = new HeaderFactory;
    }

    public function __invoke(Str $name, Str $value): Header
    {
        $factory = Factories::of($name);

        if ($factory) {
            return $factory
                ->try($this->clock, $value)
                ->match(
                    static fn($header) => $header,
                    fn() => ($this->fallback)($name, $value),
                );
        }

        return ($this->fallback)($name, $value);
    }

    public static function new(Clock $clock): self
    {
        return new self($clock);
    }
}

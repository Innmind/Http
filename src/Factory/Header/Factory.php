<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Header;

use Innmind\Http\{
    Header,
    Header\Value,
};
use Innmind\Time\Clock;
use Innmind\Immutable\Str;

/**
 * @internal
 * @psalm-immutable
 */
final class Factory
{
    private function __construct(
        private Clock $clock,
    ) {
    }

    public function __invoke(Str $name, Str $value): Header|Header\Custom
    {
        $factory = Factories::of($name);

        if ($factory) {
            return $factory
                ->try($this->clock, $value)
                ->match(
                    static fn($header) => $header,
                    static fn() => self::default($name, $value),
                );
        }

        return self::default($name, $value);
    }

    public static function new(Clock $clock): self
    {
        return new self($clock);
    }

    /**
     * @psalm-pure
     */
    private static function default(Str $name, Str $value): Header
    {
        $values = $value
            ->split(',')
            ->map(static fn($value) => $value->trim())
            ->map(static fn($value) => Value::of($value->toString()))
            ->toList();

        return Header::of(
            $name->toString(),
            ...$values,
        );
    }
}

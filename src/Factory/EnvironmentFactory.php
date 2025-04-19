<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory;

use Innmind\Http\{
    ServerRequest\Environment,
    Factory\Environment\Native,
};

/**
 * @psalm-immutable
 */
final class EnvironmentFactory
{
    /**
     * @param Native|pure-Closure(): Environment $implementation
     */
    private function __construct(
        private Native|\Closure $implementation,
    ) {
    }

    public function __invoke(): Environment
    {
        return ($this->implementation)();
    }

    public static function native(): self
    {
        return new self(Native::new());
    }

    /**
     * @psalm-pure
     *
     * @param pure-Closure(): Environment $factory
     */
    public static function of(\Closure $factory): self
    {
        return new self($factory);
    }
}

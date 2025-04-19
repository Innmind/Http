<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory;

use Innmind\Http\{
    ServerRequest\Environment,
    Factory\Environment\Defaut,
};

/**
 * @psalm-immutable
 */
final class EnvironmentFactory
{
    /**
     * @param Defaut|pure-Closure(): Environment $implementation
     */
    private function __construct(
        private Defaut|\Closure $implementation,
    ) {
    }

    public function __invoke(): Environment
    {
        return ($this->implementation)();
    }

    public static function default(): self
    {
        return new self(Defaut::new());
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

<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory;

use Innmind\Http\{
    Headers,
    Factory\Headers\Defaut,
};
use Innmind\TimeContinuum\Clock;

/**
 * @psalm-immutable
 */
final class HeadersFactory
{
    /**
     * @param Defaut|pure-Closure(): Headers $implementation
     */
    private function __construct(
        private Defaut|\Closure $implementation,
    ) {
    }

    public function __invoke(): Headers
    {
        return ($this->implementation)();
    }

    public static function default(Clock $clock): self
    {
        return new self(Defaut::new($clock));
    }

    /**
     * @psalm-pure
     *
     * @param pure-Closure(): Headers $factory
     */
    public static function of(\Closure $factory): self
    {
        return new self($factory);
    }
}

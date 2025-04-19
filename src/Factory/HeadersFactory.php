<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory;

use Innmind\Http\{
    Headers,
    Factory\Headers\Native,
};
use Innmind\TimeContinuum\Clock;

/**
 * @psalm-immutable
 */
final class HeadersFactory
{
    /**
     * @param Native|pure-Closure(): Headers $implementation
     */
    private function __construct(
        private Native|\Closure $implementation,
    ) {
    }

    public function __invoke(): Headers
    {
        return ($this->implementation)();
    }

    public static function native(Clock $clock): self
    {
        return new self(Native::new($clock));
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

<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory;

use Innmind\Http\{
    ServerRequest\Cookies,
    Factory\Cookies\Native,
};

/**
 * @psalm-immutable
 */
final class CookiesFactory
{
    /**
     * @param Native|pure-Closure(): Cookies $implementation
     */
    private function __construct(
        private Native|\Closure $implementation,
    ) {
    }

    #[\NoDiscard]
    public function __invoke(): Cookies
    {
        return ($this->implementation)();
    }

    #[\NoDiscard]
    public static function native(): self
    {
        return new self(Native::new());
    }

    /**
     * @psalm-pure
     *
     * @param pure-Closure(): Cookies $factory
     */
    #[\NoDiscard]
    public static function of(\Closure $factory): self
    {
        return new self($factory);
    }
}

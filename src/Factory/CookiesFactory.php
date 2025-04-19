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

    public function __invoke(): Cookies
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
     * @param pure-Closure(): Cookies $factory
     */
    public static function of(\Closure $factory): self
    {
        return new self($factory);
    }
}

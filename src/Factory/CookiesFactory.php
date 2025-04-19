<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory;

use Innmind\Http\{
    ServerRequest\Cookies,
    Factory\Cookies\Defaut,
};

/**
 * @psalm-immutable
 */
final class CookiesFactory
{
    /**
     * @param Defaut|pure-Closure(): Cookies $implementation
     */
    private function __construct(
        private Defaut|\Closure $implementation,
    ) {
    }

    public function __invoke(): Cookies
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
     * @param pure-Closure(): Cookies $factory
     */
    public static function of(\Closure $factory): self
    {
        return new self($factory);
    }
}

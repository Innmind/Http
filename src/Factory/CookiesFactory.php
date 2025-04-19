<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory;

use Innmind\Http\ServerRequest\Cookies;

/**
 * @psalm-immutable
 */
final class CookiesFactory
{
    /**
     * @param namespace\Cookies\Defaut|pure-Closure(): Cookies $implementation
     */
    private function __construct(
        private namespace\Cookies\Defaut|\Closure $implementation,
    ) {
    }

    public function __invoke(): Cookies
    {
        return ($this->implementation)();
    }

    public static function default(): self
    {
        return new self(namespace\Cookies\Defaut::new());
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

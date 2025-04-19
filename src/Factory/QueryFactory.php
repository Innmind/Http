<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory;

use Innmind\Http\{
    ServerRequest\Query,
    Factory\Query\Native,
};

/**
 * @psalm-immutable
 */
final class QueryFactory
{
    /**
     * @param Native|pure-Closure(): Query $implementation
     */
    private function __construct(
        private Native|\Closure $implementation,
    ) {
    }

    public function __invoke(): Query
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
     * @param pure-Closure(): Query $factory
     */
    public static function of(\Closure $factory): self
    {
        return new self($factory);
    }
}

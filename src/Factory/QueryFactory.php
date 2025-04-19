<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory;

use Innmind\Http\{
    ServerRequest\Query,
    Factory\Query\Defaut,
};

/**
 * @psalm-immutable
 */
final class QueryFactory
{
    /**
     * @param Defaut|pure-Closure(): Query $implementation
     */
    private function __construct(
        private Defaut|\Closure $implementation,
    ) {
    }

    public function __invoke(): Query
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
     * @param pure-Closure(): Query $factory
     */
    public static function of(\Closure $factory): self
    {
        return new self($factory);
    }
}

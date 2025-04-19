<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Query;

use Innmind\Http\{
    Factory\QueryFactory as QueryFactoryInterface,
    ServerRequest\Query,
};

/**
 * @psalm-immutable
 */
final class QueryFactory implements QueryFactoryInterface
{
    /**
     * @param array<string, string|array> $get
     */
    public function __construct(
        private array $get,
    ) {
    }

    #[\Override]
    public function __invoke(): Query
    {
        return Query::of($this->get);
    }

    public static function default(): self
    {
        /** @var array<string, string|array> */
        $get = $_GET;

        return new self($get);
    }
}

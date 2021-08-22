<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Query;

use Innmind\Http\{
    Factory\QueryFactory as QueryFactoryInterface,
    Message\Query,
    Message\Query\Parameter,
};

/**
 * @psalm-immutable
 */
final class QueryFactory implements QueryFactoryInterface
{
    /** @var array<int|string, string|array> */
    private array $get;

    /**
     * @param array<int|string, string|array> $get
     */
    public function __construct(array $get)
    {
        $this->get = $get;
    }

    public function __invoke(): Query
    {
        $queries = [];

        foreach ($this->get as $name => $value) {
            $queries[] = new Parameter((string) $name, $value);
        }

        return new Query(...$queries);
    }

    public static function default(): self
    {
        /** @var array<int|string, string|array> */
        $get = $_GET;

        return new self($get);
    }
}

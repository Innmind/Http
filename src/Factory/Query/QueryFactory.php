<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Query;

use Innmind\Http\{
    Factory\QueryFactory as QueryFactoryInterface,
    Message\Query,
    Message\Query\Parameter,
};

final class QueryFactory implements QueryFactoryInterface
{
    public function __invoke(): Query
    {
        $queries = [];

        /**
         * @var string $name
         * @var string|array $value
         */
        foreach ($_GET as $name => $value) {
            $queries[] = new Parameter($name, $value);
        }

        return new Query(...$queries);
    }
}

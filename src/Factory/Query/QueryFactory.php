<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Query;

use Innmind\Http\{
    Factory\QueryFactory as QueryFactoryInterface,
    Message\Query,
    Message\Query\Parameter
};
use Innmind\Immutable\Map;

final class QueryFactory implements QueryFactoryInterface
{
    public function make(): Query
    {
        $queries = [];

        foreach ($_GET as $name => $value) {
            $queries[] = new Parameter\Parameter($name, $value);
        }

        return new Query(...$queries);
    }
}

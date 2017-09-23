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
        $map = new Map('string', Parameter::class);

        foreach ($_GET as $name => $value) {
            $map = $map->put(
                $name,
                new Parameter\Parameter($name, $value)
            );
        }

        return new Query\Query($map);
    }
}

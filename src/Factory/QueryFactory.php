<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory;

use Innmind\Http\Message\{
    QueryInterface,
    Query,
    Query\ParameterInterface,
    Query\Parameter
};
use Innmind\Immutable\Map;

final class QueryFactory implements QueryFactoryInterface
{
    public function make(): QueryInterface
    {
        $map = new Map('string', ParameterInterface::class);

        foreach ($_GET as $name => $value) {
            $map = $map->put(
                $name,
                new Parameter($name, $value)
            );
        }

        return new Query($map);
    }
}

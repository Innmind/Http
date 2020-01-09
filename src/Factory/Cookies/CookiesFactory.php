<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Cookies;

use Innmind\Http\{
    Factory\CookiesFactory as CookiesFactoryInterface,
    Message\Cookies
};
use Innmind\Immutable\Map;

final class CookiesFactory implements CookiesFactoryInterface
{
    public function make(): Cookies
    {
        $map = new Map('string', 'scalar');

        foreach ($_COOKIE as $name => $value) {
            $map = $map->put(
                $name,
                $value
            );
        }

        return new Cookies($map);
    }
}

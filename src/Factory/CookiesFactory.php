<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory;

use Innmind\Http\Message\{
    CookiesInterface,
    Cookies
};
use Innmind\Immutable\Map;

final class CookiesFactory implements CookiesFactoryInterface
{
    public function make(): CookiesInterface
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

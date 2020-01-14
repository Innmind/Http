<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Cookies;

use Innmind\Http\{
    Factory\CookiesFactory as CookiesFactoryInterface,
    Message\Cookies,
};
use Innmind\Immutable\Map;

final class CookiesFactory implements CookiesFactoryInterface
{
    public function __invoke(): Cookies
    {
        $map = Map::of('string', 'string');

        /**
         * @var string $name
         * @var string $value
         */
        foreach ($_COOKIE as $name => $value) {
            $map = ($map)($name, $value);
        }

        return new Cookies($map);
    }
}

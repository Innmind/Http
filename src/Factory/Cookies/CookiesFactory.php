<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Cookies;

use Innmind\Http\{
    Factory\CookiesFactory as CookiesFactoryInterface,
    ServerRequest\Cookies,
};
use Innmind\Immutable\Map;

/**
 * @psalm-immutable
 */
final class CookiesFactory implements CookiesFactoryInterface
{
    /** @var array<string, string> */
    private array $cookies;

    /**
     * @param array<string, string> $cookies
     */
    public function __construct(array $cookies)
    {
        $this->cookies = $cookies;
    }

    #[\Override]
    public function __invoke(): Cookies
    {
        /** @var Map<string, string> */
        $map = Map::of();

        foreach ($this->cookies as $name => $value) {
            $map = ($map)($name, $value);
        }

        return Cookies::of($map);
    }

    public static function default(): self
    {
        /** @var array<string, string> */
        $cookies = $_COOKIE;

        return new self($cookies);
    }
}

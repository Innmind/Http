<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Cookies;

use Innmind\Http\ServerRequest\Cookies;
use Innmind\Immutable\Map;

/**
 * @internal
 * @psalm-immutable
 */
final class Native
{
    /**
     * @param array<string, string> $cookies
     */
    private function __construct(
        private array $cookies,
    ) {
    }

    public function __invoke(): Cookies
    {
        /** @var Map<string, string> */
        $map = Map::of();

        foreach ($this->cookies as $name => $value) {
            $map = ($map)($name, $value);
        }

        return Cookies::of($map);
    }

    public static function new(): self
    {
        /** @var array<string, string> */
        $cookies = $_COOKIE;

        return new self($cookies);
    }
}

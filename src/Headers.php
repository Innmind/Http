<?php
declare(strict_types = 1);

namespace Innmind\Http;

use Innmind\Immutable\{
    Str,
    Map,
    SideEffect,
    Maybe,
};

/**
 * @psalm-immutable
 */
final class Headers implements \Countable
{
    /** @var Map<string, Header> */
    private Map $headers;

    /**
     * @param Map<string, Header> $headers
     */
    private function __construct(Map $headers)
    {
        $this->headers = $headers;
    }

    public function __invoke(Header $header): self
    {
        return new self(($this->headers)(
            self::normalize($header->name()),
            $header,
        ));
    }

    /**
     * @no-named-arguments
     * @psalm-pure
     */
    public static function of(Header ...$headers): self
    {
        /** @var Map<string, Header> */
        $map = Map::of();

        foreach ($headers as $header) {
            $map = ($map)(
                self::normalize($header->name()),
                $header,
            );
        }

        return new self($map);
    }

    /**
     * @param string $name Case insensitive
     *
     * @return Maybe<Header>
     */
    public function get(string $name): Maybe
    {
        return $this->headers->get(self::normalize($name));
    }

    /**
     * @template T of Header
     *
     * @param class-string<T> $type
     *
     * @return Maybe<T>
     */
    public function find(string $type): Maybe
    {
        /** @var Maybe<T> */
        return $this->headers->values()->find(static fn($header) => $header instanceof $type);
    }

    /**
     * Check if the header is present
     *
     * @param string $name Case insensitive
     */
    public function contains(string $name): bool
    {
        return $this->get($name)->match(
            static fn() => true,
            static fn() => false,
        );
    }

    /**
     * @param callable(Header): void $function
     */
    public function foreach(callable $function): SideEffect
    {
        return $this->headers->values()->foreach($function);
    }

    /**
     * @template R
     *
     * @param R $carry
     * @param callable(R, Header): R $reducer
     *
     * @return R
     */
    public function reduce($carry, callable $reducer)
    {
        return $this->headers->values()->reduce($carry, $reducer);
    }

    public function count(): int
    {
        return $this->headers->size();
    }

    /**
     * @psalm-pure
     */
    private static function normalize(string $name): string
    {
        return Str::of($name)->toLower()->toString();
    }
}

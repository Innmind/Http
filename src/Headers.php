<?php
declare(strict_types = 1);

namespace Innmind\Http;

use Innmind\Immutable\{
    Str,
    SideEffect,
    Maybe,
    Map,
    Sequence,
    Predicate\Instance,
};

/**
 * @psalm-immutable
 */
final class Headers implements \Countable
{
    /**
     * @param Map<string, Header|Header\Provider> $headers
     */
    private function __construct(
        private Map $headers,
    ) {
    }

    public function __invoke(Header|Header\Provider $header): self
    {
        $name = self::normalize(match (true) {
            $header instanceof Header => $header->name(),
            default => $header->toHeader()->name(),
        });

        return new self(($this->headers)($name, $header));
    }

    /**
     * @no-named-arguments
     * @psalm-pure
     */
    public static function of(Header|Header\Provider ...$headers): self
    {
        return Sequence::of(...$headers)->reduce(
            new self(Map::of()),
            static fn(self $headers, $header) => ($headers)($header),
        );
    }

    /**
     * @param string $name Case insensitive
     *
     * @return Maybe<Header>
     */
    public function get(string $name): Maybe
    {
        $normalized = self::normalize($name);

        return $this
            ->headers
            ->get($normalized)
            ->map(static fn($header) => match (true) {
                $header instanceof Header => $header,
                default => $header->toHeader(),
            });
    }

    /**
     * @template T of Header\Provider
     *
     * @param class-string<T> $type
     *
     * @return Maybe<T>
     */
    public function find(string $type): Maybe
    {
        return $this
            ->headers
            ->values()
            ->keep(Instance::of($type))
            ->first();
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
     * @param callable(Header): bool $filter
     */
    public function filter(callable $filter): self
    {
        return new self($this->headers->filter(static fn($_, $header) => match (true) {
            $header instanceof Header => $filter($header),
            default => $filter($header->toHeader()),
        }));
    }

    /**
     * @param callable(Header|Header\Provider): void $function
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
        return $this->all()->reduce($carry, $reducer);
    }

    #[\Override]
    public function count(): int
    {
        return $this->headers->size();
    }

    /**
     * @return Sequence<Header>
     */
    public function all(): Sequence
    {
        return $this->headers->values()->map(static fn($header) => match (true) {
            $header instanceof Header => $header,
            default => $header->toHeader(),
        });
    }

    /**
     * @psalm-pure
     */
    private static function normalize(string $name): string
    {
        return Str::of($name)->toLower()->toString();
    }
}

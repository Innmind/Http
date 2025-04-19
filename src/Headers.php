<?php
declare(strict_types = 1);

namespace Innmind\Http;

use Innmind\Immutable\{
    Str,
    SideEffect,
    Maybe,
    Sequence,
    Predicate\Instance,
};

/**
 * @psalm-immutable
 */
final class Headers implements \Countable
{
    /**
     * @param Sequence<Header> $headers
     */
    private function __construct(
        private Sequence $headers,
    ) {
    }

    public function __invoke(Header $header): self
    {
        $name = self::normalize($header->name());

        return new self(
            $this
                ->headers
                ->filter(static fn($header) => self::normalize($header->name()) !== $name)
                ->add($header),
        );
    }

    /**
     * @no-named-arguments
     * @psalm-pure
     */
    public static function of(Header ...$headers): self
    {
        return Sequence::of(...$headers)->reduce(
            new self(Sequence::of()),
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

        return $this->headers->find(static fn($header) => self::normalize($header->name()) === $normalized);
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
        return $this
            ->headers
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
        return new self($this->headers->filter($filter));
    }

    /**
     * @param callable(Header): void $function
     */
    public function foreach(callable $function): SideEffect
    {
        return $this->headers->foreach($function);
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
        return $this->headers->reduce($carry, $reducer);
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
        return $this->headers;
    }

    /**
     * @psalm-pure
     */
    private static function normalize(string $name): string
    {
        return Str::of($name)->toLower()->toString();
    }
}

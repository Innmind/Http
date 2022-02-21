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

    private function __construct(Header ...$headers)
    {
        /** @var Map<string, Header> */
        $this->headers = Map::of();

        foreach ($headers as $header) {
            $this->headers = ($this->headers)(
                $this->normalize($header->name()),
                $header,
            );
        }
    }

    public function __invoke(Header $header): self
    {
        $self = clone $this;
        $self->headers = ($self->headers)(
            $this->normalize($header->name()),
            $header,
        );

        return $self;
    }

    /**
     * @no-named-arguments
     * @psalm-pure
     */
    public static function of(Header ...$headers): self
    {
        return new self(...$headers);
    }

    /**
     * @param string $name Case insensitive
     *
     * @return Maybe<Header>
     */
    public function get(string $name): Maybe
    {
        return $this->headers->get($this->normalize($name));
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

    private function normalize(string $name): string
    {
        return Str::of($name)->toLower()->toString();
    }
}

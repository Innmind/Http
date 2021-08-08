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
    /** @var Map<string, Header<Header\Value>> */
    private Map $headers;

    /**
     * @no-named-arguments
     */
    public function __construct(Header ...$headers)
    {
        /** @var Map<string, Header<Header\Value>> */
        $this->headers = Map::of();

        foreach ($headers as $header) {
            $this->headers = ($this->headers)(
                $this->normalize($header->name()),
                $header,
            );
        }
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
     * @return Maybe<Header<Header\Value>>
     */
    public function get(string $name): Maybe
    {
        return $this->headers->get($this->normalize($name));
    }

    public function add(Header ...$headers): self
    {
        $self = clone $this;

        foreach ($headers as $header) {
            $self->headers = ($self->headers)(
                $this->normalize($header->name()),
                $header,
            );
        }

        return $self;
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

    public function count()
    {
        return $this->headers->size();
    }

    private function normalize(string $name): string
    {
        return Str::of($name)->toLower()->toString();
    }
}

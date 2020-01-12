<?php
declare(strict_types = 1);

namespace Innmind\Http;

use Innmind\Http\Exception\HeaderNotFound;
use Innmind\Immutable\{
    Str,
    Map,
};

final class Headers implements \Countable
{
    private Map $headers;

    public function __construct(Header ...$headers)
    {
        $this->headers = Map::of('string', Header::class);

        foreach ($headers as $header) {
            $this->headers = ($this->headers)(
                Str::of($header->name())->toLower()->toString(),
                $header,
            );
        }
    }

    public static function of(Header ...$headers): self
    {
        return new self(...$headers);
    }

    /**
     * @param string $name Case insensitive
     *
     * @throws HeaderNotFoundException
     */
    public function get(string $name): Header
    {
        if (!$this->contains($name)) {
            throw new HeaderNotFound;
        }

        return $this->headers->get(Str::of($name)->toLower()->toString());
    }

    public function add(Header ...$headers): self
    {
        $self = clone $this;

        foreach ($headers as $header) {
            $self->headers = ($self->headers)(
                Str::of($header->name())->toLower()->toString(),
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
        return $this->headers->contains(Str::of($name)->toLower()->toString());
    }

    /**
     * @param callable(Header): void $function
     */
    public function foreach(callable $function): void
    {
        $this->headers->values()->foreach($function);
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

    /**
     * {@inheritdoc}
     */
    public function count()
    {
        return $this->headers->size();
    }
}

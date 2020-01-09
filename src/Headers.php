<?php
declare(strict_types = 1);

namespace Innmind\Http;

use Innmind\Http\Exception\HeaderNotFound;
use Innmind\Immutable\{
    MapInterface,
    Pair,
    Str,
    Map,
    Sequence
};

final class Headers implements \Iterator, \Countable
{
    private $headers;

    public function __construct(Header ...$headers)
    {
        $this->headers = Map::of('string', Header::class);

        foreach ($headers as $header) {
            $this->headers = $this->headers->put(
                (string) Str::of($header->name())->toLower(),
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
     *
     * @return Header
     */
    public function get(string $name): Header
    {
        if (!$this->contains($name)) {
            throw new HeaderNotFound;
        }

        return $this->headers->get((string) (new Str($name))->toLower());
    }

    /**
     * Check if the header is present
     *
     * @param string $name Case insensitive
     *
     * @return bool
     */
    public function contains(string $name): bool
    {
        return $this->headers->contains((string) (new Str($name))->toLower());
    }

    /**
     * {@inheritdoc}
     */
    public function current()
    {
        return $this->headers->current();
    }

    /**
     * {@inheritdoc}
     */
    public function key()
    {
        return $this->headers->key();
    }

    /**
     * {@inheritdoc}
     */
    public function next()
    {
        $this->headers->next();
    }

    /**
     * {@inheritdoc}
     */
    public function rewind()
    {
        $this->headers->rewind();
    }

    /**
     * {@inheritdoc}
     */
    public function valid()
    {
        return $this->headers->valid();
    }

    /**
     * {@inheritdoc}
     */
    public function count()
    {
        return $this->headers->size();
    }
}

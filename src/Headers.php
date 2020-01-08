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

    public function __construct(MapInterface $headers = null)
    {
        $headers = $headers ?? new Map('string', Header::class);

        if (
            (string) $headers->keyType() !== 'string' ||
            (string) $headers->valueType() !== Header::class
        ) {
            throw new \TypeError(sprintf(
                'Argument 1 must be of type MapInterface<string, %s>',
                Header::class
            ));
        }

        $this->headers = $headers->map(function(string $name, Header $header) {
            return new Pair(
                (string) (new Str($name))->toLower(),
                $header
            );
        });
    }

    public static function of(Header ...$headers): self
    {
        return new self(
            Sequence::of(...$headers)->reduce(
                new Map('string', Header::class),
                static function(MapInterface $headers, Header $header): MapInterface {
                    return $headers->put(
                        $header->name(),
                        $header
                    );
                }
            )
        );
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
        if (!$this->has($name)) {
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
    public function has(string $name): bool
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

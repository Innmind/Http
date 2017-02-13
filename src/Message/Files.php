<?php
declare(strict_types = 1);

namespace Innmind\Http\Message;

use Innmind\Http\{
    File\FileInterface,
    Exception\InvalidArgumentException,
    Exception\FileNotFoundException
};
use Innmind\Immutable\{
    MapInterface,
    Map
};

final class Files implements FilesInterface
{
    private $files;

    public function __construct(MapInterface $files = null)
    {
        $files = $files ?? new Map('string', FileInterface::class);

        if (
            (string) $files->keyType() !== 'string' ||
            (string) $files->valueType() !== FileInterface::class
        ) {
            throw new InvalidArgumentException;
        }

        $this->files = $files;
    }

    /**
     * {@inheritdoc}
     */
    public function get(string $name): FileInterface
    {
        if (!$this->has($name)) {
            throw new FileNotFoundException;
        }

        return $this->files->get($name);
    }

    /**
     * {@inheritdoc}
     */
    public function has(string $name): bool
    {
        return $this->files->contains($name);
    }

    /**
     * {@inheritdoc}
     */
    public function current()
    {
        return $this->files->current();
    }

    /**
     * {@inheritdoc}
     */
    public function key()
    {
        return $this->files->key();
    }

    /**
     * {@inheritdoc}
     */
    public function next()
    {
        $this->files->next();
    }

    /**
     * {@inheritdoc}
     */
    public function rewind()
    {
        $this->files->rewind();
    }

    /**
     * {@inheritdoc}
     */
    public function valid()
    {
        return $this->files->valid();
    }

    /**
     * {@inheritdoc}
     */
    public function count()
    {
        return $this->files->size();
    }
}

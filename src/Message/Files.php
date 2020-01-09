<?php
declare(strict_types = 1);

namespace Innmind\Http\Message;

use Innmind\Http\{
    File,
    Exception\FileNotFound
};
use Innmind\Immutable\{
    MapInterface,
    Map,
    Sequence
};

final class Files implements \Iterator, \Countable
{
    private $files;

    public function __construct(File ...$files)
    {
        $this->files = Map::of('string', File::class);

        foreach ($files as $file) {
            $this->files = $this->files->put(
                $file->uploadKey(),
                $file,
            );
        }
    }

    public static function of(File ...$files): self
    {
        return new self(...$files);
    }

    /**
     * @throws FileNotFoundException
     */
    public function get(string $name): File
    {
        if (!$this->contains($name)) {
            throw new FileNotFound;
        }

        return $this->files->get($name);
    }

    public function contains(string $name): bool
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

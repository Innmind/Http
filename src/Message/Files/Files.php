<?php
declare(strict_types = 1);

namespace Innmind\Http\Message\Files;

use Innmind\Http\{
    Message\Files as FilesInterface,
    File,
    Exception\FileNotFound
};
use Innmind\Immutable\{
    MapInterface,
    Map,
    Sequence
};

final class Files implements FilesInterface
{
    private $files;

    public function __construct(MapInterface $files = null)
    {
        $files = $files ?? new Map('string', File::class);

        if (
            (string) $files->keyType() !== 'string' ||
            (string) $files->valueType() !== File::class
        ) {
            throw new \TypeError(sprintf(
                'Argument 1 must be of type MapInterface<string, %s>',
                File::class
            ));
        }

        $this->files = $files;
    }

    public static function of(File ...$files): self
    {
        return new self(
            Sequence::of(...$files)->reduce(
                new Map('string', File::class),
                static function(MapInterface $files, File $file): MapInterface {
                    return $files->put(
                        (string) $file->name(),
                        $file
                    );
                }
            )
        );
    }

    /**
     * {@inheritdoc}
     */
    public function get(string $name): File
    {
        if (!$this->has($name)) {
            throw new FileNotFound;
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

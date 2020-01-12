<?php
declare(strict_types = 1);

namespace Innmind\Http\Message;

use Innmind\Http\{
    File,
    Exception\FileNotFound,
};
use Innmind\Immutable\Map;

final class Files implements \Countable
{
    private Map $files;

    public function __construct(File ...$files)
    {
        $this->files = Map::of('string', File::class);

        foreach ($files as $file) {
            $this->files = ($this->files)(
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
     * @param callable(File): void $function
     */
    public function foreach(callable $function): void
    {
        $this->files->values()->foreach($function);
    }

    /**
     * @template R
     *
     * @param R $carry
     * @param callable(R, File): R $reducer
     *
     * @return R
     */
    public function reduce($carry, callable $reducer)
    {
        return $this->files->values()->reduce($carry, $reducer);
    }

    /**
     * {@inheritdoc}
     */
    public function count()
    {
        return $this->files->size();
    }
}

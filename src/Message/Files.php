<?php
declare(strict_types = 1);

namespace Innmind\Http\Message;

use Innmind\Http\File;
use Innmind\Immutable\{
    Map,
    SideEffect,
    Maybe,
};

/**
 * @psalm-immutable
 */
final class Files implements \Countable
{
    /** @var Map<string, File> */
    private Map $files;

    public function __construct(File ...$files)
    {
        /** @var Map<string, File> */
        $this->files = Map::of();

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
     * @return Maybe<File>
     */
    public function get(string $name): Maybe
    {
        return $this->files->get($name);
    }

    public function contains(string $name): bool
    {
        return $this->files->contains($name);
    }

    /**
     * @param callable(File): void $function
     */
    public function foreach(callable $function): SideEffect
    {
        return $this->files->values()->foreach($function);
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

    public function count()
    {
        return $this->files->size();
    }
}

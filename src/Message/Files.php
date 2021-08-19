<?php
declare(strict_types = 1);

namespace Innmind\Http\Message;

use Innmind\Http\File;
use Innmind\Immutable\{
    Map,
    Maybe,
};

/**
 * @psalm-immutable
 */
final class Files
{
    /** @var Map<string, File> */
    private Map $files;

    /**
     * @no-named-arguments
     */
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

    /**
     * @return Maybe<File>
     */
    public function get(string $name): Maybe
    {
        return $this->files->get($name);
    }
}

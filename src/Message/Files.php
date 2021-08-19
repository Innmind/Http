<?php
declare(strict_types = 1);

namespace Innmind\Http\Message;

use Innmind\Http\File\Status;
use Innmind\Filesystem\File;
use Innmind\Immutable\{
    Map,
    Either,
};

/**
 * @psalm-immutable
 */
final class Files
{
    /** @var Map<string, Either<Status, File>> */
    private Map $files;

    /**
     * @param Map<string, Either<Status, File>> $files
     */
    public function __construct(Map $files = null)
    {
        $this->files = $files ?? Map::of();
    }

    /**
     * @return Either<Status, File>
     */
    public function get(string $name): Either
    {
        /** @var Either<Status, File> */
        return $this->files->get($name)->match(
            static fn($either) => $either,
            static fn() => Either::left(new Status\NotUploaded),
        );
    }
}

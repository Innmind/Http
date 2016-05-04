<?php
declare(strict_types = 1);

namespace Innmind\Http\File;

use Innmind\Filesystem\{
    FileInterface as FilesystemFileInterface,
    MediaTypeInterface
};

interface FileInterface extends FilesystemFileInterface
{
    public function status(): StatusInterface;
    public function clientMediaType(): MediaTypeInterface;
}

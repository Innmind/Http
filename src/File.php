<?php
declare(strict_types = 1);

namespace Innmind\Http;

use Innmind\Http\File\Status;
use Innmind\Filesystem\{
    FileInterface as FilesystemFile,
    MediaTypeInterface
};

interface File extends FilesystemFile
{
    public function status(): Status;
    public function clientMediaType(): MediaTypeInterface;
}

<?php
declare(strict_types = 1);

namespace Innmind\Http;

use Innmind\Http\File\Status;
use Innmind\Filesystem\File as FilesystemFile;

interface File extends FilesystemFile
{
    public function uploadKey(): string;
    public function status(): Status;
}

<?php
declare(strict_types = 1);

namespace Innmind\Http\File\Status;

use Innmind\Http\File\Status;

final class StoppedByExtension implements Status
{
    public function value(): int
    {
        return \UPLOAD_ERR_EXTENSION;
    }

    public function toString(): string
    {
        return 'UPLOAD_ERR_EXTENSION';
    }
}

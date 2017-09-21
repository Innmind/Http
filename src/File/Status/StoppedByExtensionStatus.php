<?php
declare(strict_types = 1);

namespace Innmind\Http\File\Status;

use Innmind\Http\File\Status;

final class StoppedByExtensionStatus implements Status
{
    public function value(): int
    {
        return UPLOAD_ERR_EXTENSION;
    }

    public function __toString(): string
    {
        return 'UPLOAD_ERR_EXTENSION';
    }
}

<?php
declare(strict_types = 1);

namespace Innmind\Http\File\Status;

use Innmind\Http\File\Status;

final class WriteFailed implements Status
{
    public function value(): int
    {
        return \UPLOAD_ERR_CANT_WRITE;
    }

    public function toString(): string
    {
        return 'UPLOAD_ERR_CANT_WRITE';
    }
}

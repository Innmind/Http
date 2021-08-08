<?php
declare(strict_types = 1);

namespace Innmind\Http\File\Status;

use Innmind\Http\File\Status;

/**
 * @psalm-immutable
 */
final class Ok implements Status
{
    public function value(): int
    {
        return \UPLOAD_ERR_OK;
    }

    public function toString(): string
    {
        return 'UPLOAD_ERR_OK';
    }
}

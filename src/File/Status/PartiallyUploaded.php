<?php
declare(strict_types = 1);

namespace Innmind\Http\File\Status;

use Innmind\Http\File\Status;

final class PartiallyUploaded implements Status
{
    public function value(): int
    {
        return \UPLOAD_ERR_PARTIAL;
    }

    public function toString(): string
    {
        return 'UPLOAD_ERR_PARTIAL';
    }
}

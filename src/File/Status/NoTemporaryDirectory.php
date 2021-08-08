<?php
declare(strict_types = 1);

namespace Innmind\Http\File\Status;

use Innmind\Http\File\Status;

/**
 * @psalm-immutable
 */
final class NoTemporaryDirectory implements Status
{
    public function value(): int
    {
        return \UPLOAD_ERR_NO_TMP_DIR;
    }

    public function toString(): string
    {
        return 'UPLOAD_ERR_NO_TMP_DIR';
    }
}

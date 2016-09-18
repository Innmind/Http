<?php
declare(strict_types = 1);

namespace Innmind\Http\File;

final class NoTemporaryDirectoryStatus implements StatusInterface
{
    public function value(): int
    {
        return UPLOAD_ERR_NO_TMP_DIR;
    }

    public function __toString(): string
    {
        return 'UPLOAD_ERR_NO_TMP_DIR';
    }
}

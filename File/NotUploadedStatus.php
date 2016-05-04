<?php
declare(strict_types = 1);

namespace Innmind\Http\File;

final class NotUploadedStatus implements StatusInterface
{
    public function value(): int
    {
        return UPLOAD_ERR_NO_FILE;
    }

    public function __toString(): string
    {
        return 'UPLOAD_ERR_NO_FILE';
    }
}

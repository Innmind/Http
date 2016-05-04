<?php
declare(strict_types = 1);

namespace Innmind\Http\File;

final class WriteFailedStatus implements StatusInterface
{
    public function value(): int
    {
        return UPLOAD_ERR_CANT_WRITE;
    }

    public function __toString(): string
    {
        return 'UPLOAD_ERR_CANT_WRITE';
    }
}

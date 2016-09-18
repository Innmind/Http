<?php
declare(strict_types = 1);

namespace Innmind\Http\File;

final class OkStatus implements StatusInterface
{
    public function value(): int
    {
        return UPLOAD_ERR_OK;
    }

    public function __toString(): string
    {
        return 'UPLOAD_ERR_OK';
    }
}

<?php
declare(strict_types = 1);

namespace Innmind\Http\File;

final class PartiallyUploadedStatus implements StatusInterface
{
    public function value(): int
    {
        return UPLOAD_ERR_PARTIAL;
    }

    public function __toString(): string
    {
        return 'UPLOAD_ERR_PARTIAL';
    }
}

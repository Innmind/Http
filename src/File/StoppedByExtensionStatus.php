<?php
declare(strict_types = 1);

namespace Innmind\Http\File;

final class StoppedByExtensionStatus implements StatusInterface
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

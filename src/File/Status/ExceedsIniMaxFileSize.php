<?php
declare(strict_types = 1);

namespace Innmind\Http\File\Status;

use Innmind\Http\File\Status;

final class ExceedsIniMaxFileSize implements Status
{
    public function value(): int
    {
        return UPLOAD_ERR_INI_SIZE;
    }

    public function toString(): string
    {
        return 'UPLOAD_ERR_INI_SIZE';
    }
}

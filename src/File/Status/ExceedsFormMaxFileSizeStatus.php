<?php
declare(strict_types = 1);

namespace Innmind\Http\File\Status;

use Innmind\Http\File\Status;

final class ExceedsFormMaxFileSizeStatus implements Status
{
    public function value(): int
    {
        return UPLOAD_ERR_FORM_SIZE;
    }

    public function __toString(): string
    {
        return 'UPLOAD_ERR_FORM_SIZE';
    }
}

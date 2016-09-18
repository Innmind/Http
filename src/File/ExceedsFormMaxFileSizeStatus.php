<?php
declare(strict_types = 1);

namespace Innmind\Http\File;

final class ExceedsFormMaxFileSizeStatus implements StatusInterface
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

<?php
declare(strict_types = 1);

namespace Innmind\Http\File\Status;

use Innmind\Http\File\Status;

/**
 * @psalm-immutable
 */
final class ExceedsFormMaxFileSize implements Status
{
    public function value(): int
    {
        return \UPLOAD_ERR_FORM_SIZE;
    }

    public function toString(): string
    {
        return 'UPLOAD_ERR_FORM_SIZE';
    }
}

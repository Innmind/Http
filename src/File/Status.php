<?php
declare(strict_types = 1);

namespace Innmind\Http\File;

/**
 * @psalm-immutable
 */
enum Status
{
    case exceedsFormMaxFileSize;
    case exceedsIniMaxFileSize;
    case noTemporaryDirectory;
    case notUploaded;
    case partiallyUploaded;
    case stoppedByExtension;
    case writeFailed;
}

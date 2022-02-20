<?php
declare(strict_types = 1);

namespace Innmind\Http\Message;

use Innmind\Http\Message;

/**
 * @psalm-immutable
 */
interface Response extends Message
{
    public function statusCode(): StatusCode;
}

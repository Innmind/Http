<?php
declare(strict_types = 1);

namespace Innmind\Http\Message;

use Innmind\Http\Message;

interface Response extends Message
{
    public function statusCode(): StatusCode;
    public function reasonPhrase(): ReasonPhrase;
}

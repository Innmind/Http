<?php
declare(strict_types = 1);

namespace Innmind\Http\Message;

use Innmind\Http\Message;
use Innmind\Url\Url;

interface Request extends Message
{
    public function url(): Url;
    public function method(): Method;
}

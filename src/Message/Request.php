<?php
declare(strict_types = 1);

namespace Innmind\Http\Message;

use Innmind\Http\Message;
use Innmind\Url\UrlInterface;

interface Request extends Message
{
    public function url(): UrlInterface;
    public function method(): Method;
}

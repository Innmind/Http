<?php
declare(strict_types = 1);

namespace Innmind\Http\Message;

use Innmind\Http\MessageInterface;
use Innmind\Url\UrlInterface;

interface RequestInterface extends MessageInterface
{
    public function url(): UrlInterface;
    public function method(): MethodInterface;
}

<?php
declare(strict_types = 1);

namespace Innmind\Http;

use Innmind\Filesystem\StreamInterface;

interface MessageInterface
{
    public function protocolVersion(): ProtocolVersionInterface;
    public function headers(): HeadersInterface;
    public function body(): StreamInterface;
}

<?php
declare(strict_types = 1);

namespace Innmind\Http;

use Innmind\Filesystem\StreamInterface;

interface Message
{
    public function protocolVersion(): ProtocolVersion;
    public function headers(): Headers;
    public function body(): StreamInterface;
}

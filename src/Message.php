<?php
declare(strict_types = 1);

namespace Innmind\Http;

use Innmind\Filesystem\File\Content;

interface Message
{
    public function protocolVersion(): ProtocolVersion;
    public function headers(): Headers;
    public function body(): Content;
}

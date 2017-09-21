<?php
declare(strict_types = 1);

namespace Innmind\Http\Message;

use Innmind\Http\{
    Message as MessageInterface,
    ProtocolVersion,
    Headers
};
use Innmind\Filesystem\StreamInterface;

abstract class Message implements MessageInterface
{
    private $protocolVersion;
    private $headers;
    private $body;

    public function __construct(
        ProtocolVersion $protocolVersion,
        Headers $headers,
        StreamInterface $body
    ) {
        $this->protocolVersion = $protocolVersion;
        $this->headers = $headers;
        $this->body = $body;
    }

    public function protocolVersion(): ProtocolVersion
    {
        return $this->protocolVersion;
    }

    public function headers(): Headers
    {
        return $this->headers;
    }

    public function body(): StreamInterface
    {
        return $this->body;
    }
}

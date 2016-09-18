<?php
declare(strict_types = 1);

namespace Innmind\Http;

use Innmind\Filesystem\StreamInterface;

abstract class Message implements MessageInterface
{
    private $protocolVersion;
    private $headers;
    private $body;

    public function __construct(
        ProtocolVersionInterface $protocolVersion,
        HeadersInterface $headers,
        StreamInterface $body
    ) {
        $this->protocolVersion = $protocolVersion;
        $this->headers = $headers;
        $this->body = $body;
    }

    public function protocolVersion(): ProtocolVersionInterface
    {
        return $this->protocolVersion;
    }

    public function headers(): HeadersInterface
    {
        return $this->headers;
    }

    public function body(): StreamInterface
    {
        return $this->body;
    }
}

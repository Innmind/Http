<?php
declare(strict_types = 1);

namespace Innmind\Http\Message;

use Innmind\Http\{
    Message as MessageInterface,
    ProtocolVersion,
    Headers,
};
use Innmind\Stream\Readable;

abstract class Message implements MessageInterface
{
    private ProtocolVersion $protocolVersion;
    private Headers $headers;
    private Readable $body;

    public function __construct(
        ProtocolVersion $protocolVersion,
        Headers $headers,
        Readable $body
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

    public function body(): Readable
    {
        return $this->body;
    }
}

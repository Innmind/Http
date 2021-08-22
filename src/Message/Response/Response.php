<?php
declare(strict_types = 1);

namespace Innmind\Http\Message\Response;

use Innmind\Http\{
    Message\Response as ResponseInterface,
    Message\ReasonPhrase,
    Message\StatusCode,
    ProtocolVersion,
    Headers,
};
use Innmind\Stream\Readable;
use Innmind\Filesystem\Stream\NullStream;

final class Response implements ResponseInterface
{
    private ProtocolVersion $protocolVersion;
    private Headers $headers;
    private Readable $body;
    private StatusCode $statusCode;
    private ReasonPhrase $reasonPhrase;

    public function __construct(
        StatusCode $statusCode,
        ReasonPhrase $reasonPhrase,
        ProtocolVersion $protocolVersion,
        Headers $headers = null,
        Readable $body = null,
    ) {
        $this->protocolVersion = $protocolVersion;
        $this->headers = $headers ?? new Headers;
        $this->body = $body ?? new NullStream;
        $this->statusCode = $statusCode;
        $this->reasonPhrase = $reasonPhrase;
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

    public function statusCode(): StatusCode
    {
        return $this->statusCode;
    }

    public function reasonPhrase(): ReasonPhrase
    {
        return $this->reasonPhrase;
    }
}

<?php
declare(strict_types = 1);

namespace Innmind\Http\Message\Request;

use Innmind\Http\{
    Message\Request as RequestInterface,
    Message\Method,
    ProtocolVersion,
    Headers,
};
use Innmind\Url\Url;
use Innmind\Stream\Readable;
use Innmind\Filesystem\Stream\NullStream;

final class Request implements RequestInterface
{
    private Url $url;
    private Method $method;
    private ProtocolVersion $protocolVersion;
    private Headers $headers;
    private Readable $body;

    public function __construct(
        Url $url,
        Method $method,
        ProtocolVersion $protocolVersion,
        Headers $headers = null,
        Readable $body = null,
    ) {
        $this->url = $url;
        $this->method = $method;
        $this->protocolVersion = $protocolVersion;
        $this->headers = $headers ?? new Headers;
        $this->body = $body ?? new NullStream;
    }

    public function url(): Url
    {
        return $this->url;
    }

    public function method(): Method
    {
        return $this->method;
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

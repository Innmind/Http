<?php
declare(strict_types = 1);

namespace Innmind\Http;

use Innmind\Url\Url;
use Innmind\Filesystem\File\Content;

/**
 * @psalm-immutable
 */
final class Request
{
    private Url $url;
    private Method $method;
    private ProtocolVersion $protocolVersion;
    private Headers $headers;
    private Content $body;

    public function __construct(
        Url $url,
        Method $method,
        ProtocolVersion $protocolVersion,
        Headers $headers = null,
        Content $body = null,
    ) {
        $this->url = $url;
        $this->method = $method;
        $this->protocolVersion = $protocolVersion;
        $this->headers = $headers ?? Headers::of();
        $this->body = $body ?? Content::none();
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

    public function body(): Content
    {
        return $this->body;
    }
}

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
    private function __construct(
        private Url $url,
        private Method $method,
        private ProtocolVersion $protocolVersion,
        private Headers $headers,
        private Content $body,
    ) {
    }

    /**
     * @psalm-pure
     */
    public static function of(
        Url $url,
        Method $method,
        ProtocolVersion $protocolVersion,
        ?Headers $headers = null,
        ?Content $body = null,
    ): self {
        return new self(
            $url,
            $method,
            $protocolVersion,
            $headers ?? Headers::of(),
            $body ?? Content::none(),
        );
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

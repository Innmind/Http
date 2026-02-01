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
    #[\NoDiscard]
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

    #[\NoDiscard]
    public function url(): Url
    {
        return $this->url;
    }

    #[\NoDiscard]
    public function method(): Method
    {
        return $this->method;
    }

    #[\NoDiscard]
    public function protocolVersion(): ProtocolVersion
    {
        return $this->protocolVersion;
    }

    #[\NoDiscard]
    public function headers(): Headers
    {
        return $this->headers;
    }

    #[\NoDiscard]
    public function body(): Content
    {
        return $this->body;
    }
}

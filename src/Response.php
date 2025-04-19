<?php
declare(strict_types = 1);

namespace Innmind\Http;

use Innmind\Http\Response\StatusCode;
use Innmind\Filesystem\File\Content;

/**
 * @psalm-immutable
 */
final class Response
{
    private function __construct(
        private StatusCode $statusCode,
        private ProtocolVersion $protocolVersion,
        private Headers $headers,
        private Content $body,
    ) {
    }

    /**
     * @psalm-pure
     */
    public static function of(
        StatusCode $statusCode,
        ProtocolVersion $protocolVersion,
        ?Headers $headers = null,
        ?Content $body = null,
    ): self {
        return new self(
            $statusCode,
            $protocolVersion,
            $headers ?? Headers::of(),
            $body ?? Content::none(),
        );
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

    public function statusCode(): StatusCode
    {
        return $this->statusCode;
    }
}

<?php
declare(strict_types = 1);

namespace Innmind\Http\Message;

use Innmind\Http\{
    Message,
    ProtocolVersionInterface,
    HeadersInterface
};
use Innmind\Url\UrlInterface;
use Innmind\Filesystem\StreamInterface;

class Request extends Message implements RequestInterface
{
    private $url;
    private $method;

    public function __construct(
        UrlInterface $url,
        MethodInterface $method,
        ProtocolVersionInterface $protocolVersion,
        HeadersInterface $headers,
        StreamInterface $body
    ) {
        $this->url = $url;
        $this->method = $method;

        parent::__construct($protocolVersion, $headers, $body);
    }

    public function url(): UrlInterface
    {
        return $this->url;
    }

    public function method(): MethodInterface
    {
        return $this->method;
    }
}

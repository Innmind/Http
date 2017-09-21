<?php
declare(strict_types = 1);

namespace Innmind\Http\Message\Request;

use Innmind\Http\{
    Message\Request as RequestInterface,
    Message\Message,
    Message\Method,
    ProtocolVersion,
    Headers
};
use Innmind\Url\UrlInterface;
use Innmind\Filesystem\{
    StreamInterface,
    Stream\NullStream
};

class Request extends Message implements RequestInterface
{
    private $url;
    private $method;

    public function __construct(
        UrlInterface $url,
        Method $method,
        ProtocolVersion $protocolVersion,
        Headers $headers = null,
        StreamInterface $body = null
    ) {
        $this->url = $url;
        $this->method = $method;

        parent::__construct(
            $protocolVersion,
            $headers ?? new Headers\Headers,
            $body ?? new NullStream
        );
    }

    public function url(): UrlInterface
    {
        return $this->url;
    }

    public function method(): Method
    {
        return $this->method;
    }
}

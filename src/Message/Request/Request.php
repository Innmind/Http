<?php
declare(strict_types = 1);

namespace Innmind\Http\Message\Request;

use Innmind\Http\{
    Message\Request as RequestInterface,
    Message\Message,
    Message\Method,
    ProtocolVersion,
    Headers,
};
use Innmind\Url\Url;
use Innmind\Stream\Readable;
use Innmind\Filesystem\Stream\NullStream;

class Request extends Message implements RequestInterface
{
    private Url $url;
    private Method $method;

    public function __construct(
        Url $url,
        Method $method,
        ProtocolVersion $protocolVersion,
        Headers $headers = null,
        Readable $body = null
    ) {
        $this->url = $url;
        $this->method = $method;

        parent::__construct(
            $protocolVersion,
            $headers ?? new Headers,
            $body ?? new NullStream,
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
}

<?php
declare(strict_types = 1);

namespace Innmind\Http\Message\Response;

use Innmind\Http\{
    Message\Response as ResponseInterface,
    Message\Message,
    Message\ReasonPhrase,
    Message\StatusCode,
    ProtocolVersion,
    Headers,
};
use Innmind\Stream\Readable;
use Innmind\Filesystem\Stream\NullStream;

final class Response extends Message implements ResponseInterface
{
    private StatusCode $statusCode;
    private ReasonPhrase $reasonPhrase;

    public function __construct(
        StatusCode $statusCode,
        ReasonPhrase $reasonPhrase,
        ProtocolVersion $protocolVersion,
        Headers $headers = null,
        Readable $body = null
    ) {
        $this->statusCode = $statusCode;
        $this->reasonPhrase = $reasonPhrase;

        parent::__construct(
            $protocolVersion,
            $headers ?? new Headers,
            $body ?? new NullStream,
        );
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

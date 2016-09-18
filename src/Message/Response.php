<?php
declare(strict_types = 1);

namespace Innmind\Http\Message;

use Innmind\Http\{
    Message,
    ProtocolVersionInterface,
    HeadersInterface
};
use Innmind\Filesystem\StreamInterface;

final class Response extends Message implements ResponseInterface
{
    private $statusCode;
    private $reasonPhrase;

    public function __construct(
        StatusCodeInterface $statusCode,
        ReasonPhraseInterface $reasonPhrase,
        ProtocolVersionInterface $protocolVersion,
        HeadersInterface $headers,
        StreamInterface $body
    ) {
        $this->statusCode = $statusCode;
        $this->reasonPhrase = $reasonPhrase;

        parent::__construct($protocolVersion, $headers, $body);
    }

    public function statusCode(): StatusCodeInterface
    {
        return $this->statusCode;
    }

    public function reasonPhrase(): ReasonPhraseInterface
    {
        return $this->reasonPhrase;
    }
}

<?php
declare(strict_types = 1);

namespace Innmind\Http\Message\Response;

use Innmind\Http\{
    Message\Response as ResponseInterface,
    Message\StatusCode,
    Message\ReasonPhrase,
    ProtocolVersion,
    Headers,
};
use Innmind\Stream\Readable;

final class Stringable implements ResponseInterface
{
    private $response;

    public function __construct(ResponseInterface $response)
    {
        $this->response = $response;
    }

    public function statusCode(): StatusCode
    {
        return $this->response->statusCode();
    }

    public function reasonPhrase(): ReasonPhrase
    {
        return $this->response->reasonPhrase();
    }

    public function protocolVersion(): ProtocolVersion
    {
        return $this->response->protocolVersion();
    }

    public function headers(): Headers
    {
        return $this->response->headers();
    }

    public function body(): Readable
    {
        return $this->response->body();
    }

    public function __toString(): string
    {
        $headers = \iterator_to_array($this->headers());
        $headers = \implode("\n", $headers);

        return <<<RAW
HTTP/{$this->protocolVersion()} {$this->statusCode()} {$this->reasonPhrase()}
$headers

{$this->body()}
RAW;
    }
}

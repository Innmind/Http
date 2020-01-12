<?php
declare(strict_types = 1);

namespace Innmind\Http\Message\Response;

use Innmind\Http\{
    Message\Response as ResponseInterface,
    Message\StatusCode,
    Message\ReasonPhrase,
    ProtocolVersion,
    Headers,
    Header,
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

    public function toString(): string
    {
        $headers = $this->headers()->reduce(
            [],
            static function(array $headers, Header $header): array {
                $headers[] = $header;

                return $headers;
            },
        );
        $headers = \array_map(
            fn(Header $header): string => $header->toString(),
            $headers,
        );
        $headers = \implode("\n", $headers);

        return <<<RAW
HTTP/{$this->protocolVersion()->toString()} {$this->statusCode()->toString()} {$this->reasonPhrase()->toString()}
$headers

{$this->body()}
RAW;
    }
}

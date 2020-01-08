<?php
declare(strict_types = 1);

namespace Innmind\Http\Translator\Response;

use Innmind\Http\{
    Factory\HeaderFactory,
    Message\Response\Response,
    Message\StatusCode,
    Message\ReasonPhrase,
    ProtocolVersion,
    Headers\Headers,
    Header
};
use Innmind\Filesystem\Stream\StringStream;
use Innmind\Immutable\{
    Map,
    Str
};
use Psr\Http\Message\ResponseInterface;

final class Psr7Translator
{
    private $headerFactory;

    public function __construct(HeaderFactory $headerFactory)
    {
        $this->headerFactory = $headerFactory;
    }

    public function translate(ResponseInterface $response): Response
    {
        list($major, $minor) = explode('.', $response->getProtocolVersion());

        return new Response(
            new StatusCode($code = $response->getStatusCode()),
            new ReasonPhrase(ReasonPhrase::defaults()->get($code)),
            new ProtocolVersion((int) $major, (int) $minor),
            $this->translateHeaders($response->getHeaders()),
            new StringStream((string) $response->getBody())
        );
    }

    private function translateHeaders(array $rawHeaders): Headers
    {
        $headers = new Map('string', Header::class);

        foreach ($rawHeaders as $name => $values) {
            $header = $this->headerFactory->make(
                new Str($name),
                new Str(implode(', ', $values))
            );
            $headers = $headers->put(
                $header->name(),
                $header
            );
        }

        return new Headers($headers);
    }
}

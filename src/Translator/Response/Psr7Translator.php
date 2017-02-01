<?php
declare(strict_types = 1);

namespace Innmind\Http\Translator\Response;

use Innmind\Http\{
    Factory\HeaderFactoryInterface,
    Message\Response,
    Message\StatusCode,
    Message\ReasonPhrase,
    ProtocolVersion,
    Headers,
    Header\HeaderInterface
};
use Innmind\Filesystem\Stream\StringStream;
use Innmind\Immutable\{
    Map,
    StringPrimitive as Str
};
use Psr\Http\Message\ResponseInterface;

final class Psr7Translator
{
    private $headerFactory;

    public function __construct(HeaderFactoryInterface $headerFactory)
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
        $headers = new Map('string', HeaderInterface::class);

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

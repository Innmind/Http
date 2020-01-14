<?php
declare(strict_types = 1);

namespace Innmind\Http\Translator\Response;

use Innmind\Http\{
    Factory\HeaderFactory,
    Message\Response\Response,
    Message\StatusCode,
    Message\ReasonPhrase,
    ProtocolVersion,
    Headers,
    Header,
};
use Innmind\Stream\Readable\Stream;
use Innmind\Immutable\{
    Map,
    Str,
};
use Psr\Http\Message\ResponseInterface;

final class Psr7Translator
{
    private HeaderFactory $headerFactory;

    public function __construct(HeaderFactory $headerFactory)
    {
        $this->headerFactory = $headerFactory;
    }

    public function __invoke(ResponseInterface $response): Response
    {
        [$major, $minor] = \explode('.', $response->getProtocolVersion());

        return new Response(
            new StatusCode($code = $response->getStatusCode()),
            new ReasonPhrase(ReasonPhrase::defaults()->get($code)),
            new ProtocolVersion((int) $major, (int) $minor),
            $this->translateHeaders($response->getHeaders()),
            Stream::ofContent((string) $response->getBody()),
        );
    }

    private function translateHeaders(array $rawHeaders): Headers
    {
        $headers = [];

        /**
         * @var string $name
         * @var array<string> $values
         */
        foreach ($rawHeaders as $name => $values) {
            $headers[] = ($this->headerFactory)(
                Str::of($name),
                Str::of(\implode(', ', $values)),
            );
        }

        return new Headers(...$headers);
    }
}

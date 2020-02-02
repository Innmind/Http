<?php
declare(strict_types = 1);

namespace Innmind\Http\Translator\Response;

use Innmind\Http\{
    Message\Response,
    Header,
    Adapter\Psr7\Stream,
};
use function Innmind\Immutable\unwrap;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Psr7\Response as PsrReponse;

final class ToPsr7
{
    public function __invoke(Response $response): ResponseInterface
    {
        return new PsrReponse(
            $response->statusCode()->value(),
            $response->headers()->reduce(
                [],
                static function(array $headers, Header $header): array {
                    $headers[$header->name()] = unwrap($header->values()->mapTo(
                        'string',
                        fn(Header\Value $value): string => $value->toString(),
                    ));

                    return $headers;
                },
            ),
            new Stream($response->body()),
            $response->protocolVersion()->toString(),
            $response->reasonPhrase()->toString(),
        );
    }
}

<?php
declare(strict_types = 1);

namespace Innmind\Http\Translator\Response;

use Innmind\Http\{
    Message\Response,
    Headers,
    Header\Value
};
use Symfony\Component\HttpFoundation\Response as SfResponse;

final class SymfonyTranslator
{
    public function __invoke(Response $response): SfResponse
    {
        return new SfResponse(
            (string) $response->body(),
            $response->statusCode()->value(),
            $this->translateHeaders($response->headers())
        );
    }

    private function translateHeaders(Headers $headers): array
    {
        $symfony = [];

        foreach ($headers as $header) {
            $symfony[$header->name()] = $header->values()->reduce(
                [],
                static function(array $values, Value $value): array {
                    $values[] = $value->toString();

                    return $values;
                }
            );
        }

        return $symfony;
    }
}

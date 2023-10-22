<?php
declare(strict_types = 1);

namespace Innmind\Http\Response;

use Innmind\Http\Response;
use Innmind\Filesystem\File\Content;
use Innmind\Immutable\{
    Sequence,
    Str,
};

/**
 * @psalm-immutable
 */
final class Stringable
{
    private function __construct()
    {
    }

    public function __invoke(Response $response): Content
    {
        $status = Str::of("HTTP/%s %s %s\n")->sprintf(
            $response->protocolVersion()->toString(),
            $response->statusCode()->toString(),
            $response->statusCode()->reasonPhrase(),
        );
        $headers = $response
            ->headers()
            ->all()
            ->map(static fn($header) => $header->toString())
            ->map(Str::of(...))
            ->map(static fn($header) => $header->append("\n"));
        $body = $response->body()->chunks();

        return Content::ofChunks(
            Sequence::lazyStartingWith($status)
                ->append($headers)
                ->add(Str::of("\n"))
                ->append($body),
        );
    }

    /**
     * @psalm-pure
     */
    public static function new(): self
    {
        return new self;
    }
}

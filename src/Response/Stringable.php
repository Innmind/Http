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

        return Content::ofChunks(
            $response
                ->body()
                ->chunks()
                ->prepend(
                    Sequence::of($status)
                        ->append($headers)
                        ->add(Str::of("\n")),
                ),
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

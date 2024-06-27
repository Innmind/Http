<?php
declare(strict_types = 1);

namespace Innmind\Http\Request;

use Innmind\Http\Request;
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

    public function __invoke(Request $request): Content
    {
        $status = Str::of("%s %s HTTP/%s\n")->sprintf(
            $request->method()->toString(),
            $request->url()->toString(),
            $request->protocolVersion()->toString(),
        );
        $headers = $request
            ->headers()
            ->all()
            ->map(static fn($header) => $header->toString())
            ->map(Str::of(...))
            ->map(static fn($header) => $header->append("\n"));

        return Content::ofChunks(
            $request
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

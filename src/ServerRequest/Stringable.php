<?php
declare(strict_types = 1);

namespace Innmind\Http\ServerRequest;

use Innmind\Http\ServerRequest;
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

    #[\NoDiscard]
    public function __invoke(ServerRequest $request): Content
    {
        $status = Str::of("%s %s%s HTTP/%s\n")->sprintf(
            $request->method()->toString(),
            $request->url()->path()->toString(),
            $this->queryString($request),
            $request->protocolVersion()->toString(),
        );
        $headers = $request
            ->headers()
            ->all()
            ->map(static fn($header) => $header->toString())
            ->map(Str::of(...))
            ->map(static fn($header) => $header->append("\n"));

        return Content::ofChunks(
            $this
                ->bodyChunks($request)
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
    #[\NoDiscard]
    public static function new(): self
    {
        return new self;
    }

    private function queryString(ServerRequest $request): string
    {
        if (\count($request->query()) === 0) {
            return '';
        }

        return '?'.\rawurldecode(\http_build_query($request->query()->data()));
    }

    /**
     * @return Sequence<Str>
     */
    private function bodyChunks(ServerRequest $request): Sequence
    {
        if (\count($request->form()) !== 0) {
            return Sequence::of($request->form()->data())
                ->map(\http_build_query(...))
                ->map(\rawurldecode(...))
                ->map(Str::of(...));
        }

        return $request->body()->chunks();
    }
}

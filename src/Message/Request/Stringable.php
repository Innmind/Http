<?php
declare(strict_types = 1);

namespace Innmind\Http\Message\Request;

use Innmind\Http\{
    Request,
    Message\Method,
    ProtocolVersion,
    Headers,
    Header,
};
use Innmind\Url\Url;
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
    private Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @psalm-pure
     */
    public static function of(Request $request): self
    {
        return new self($request);
    }

    public function url(): Url
    {
        return $this->request->url();
    }

    public function method(): Method
    {
        return $this->request->method();
    }

    public function protocolVersion(): ProtocolVersion
    {
        return $this->request->protocolVersion();
    }

    public function headers(): Headers
    {
        return $this->request->headers();
    }

    public function body(): Content
    {
        return $this->request->body();
    }

    public function asContent(): Content
    {
        $status = Str::of("%s %s HTTP/%s\n")->sprintf(
            $this->method()->toString(),
            $this->url()->toString(),
            $this->protocolVersion()->toString(),
        );
        $headers = $this
            ->headers()
            ->all()
            ->map(static fn($header) => $header->toString())
            ->map(Str::of(...))
            ->map(static fn($header) => $header->append("\n"));
        $body = $this->body()->chunks();

        return Content::ofChunks(
            Sequence::lazyStartingWith($status)
                ->append($headers)
                ->add(Str::of("\n"))
                ->append($body),
        );
    }

    public function toString(): string
    {
        return $this->asContent()->toString();
    }
}

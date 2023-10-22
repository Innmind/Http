<?php
declare(strict_types = 1);

namespace Innmind\Http\Message\Response;

use Innmind\Http\{
    Response,
    Message\StatusCode,
    Message\ReasonPhrase,
    ProtocolVersion,
    Headers,
    Header,
};
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
    private Response $response;

    public function __construct(Response $response)
    {
        $this->response = $response;
    }

    /**
     * @psalm-pure
     */
    public static function of(Response $response): self
    {
        return new self($response);
    }

    public function statusCode(): StatusCode
    {
        return $this->response->statusCode();
    }

    public function protocolVersion(): ProtocolVersion
    {
        return $this->response->protocolVersion();
    }

    public function headers(): Headers
    {
        return $this->response->headers();
    }

    public function body(): Content
    {
        return $this->response->body();
    }

    public function asContent(): Content
    {
        $status = Str::of("HTTP/%s %s %s\n")->sprintf(
            $this->protocolVersion()->toString(),
            $this->statusCode()->toString(),
            $this->statusCode()->reasonPhrase(),
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

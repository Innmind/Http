<?php
declare(strict_types = 1);

namespace Innmind\Http\Message\Response;

use Innmind\Http\{
    Message\Response as ResponseInterface,
    Message\StatusCode,
    Message\ReasonPhrase,
    ProtocolVersion,
    Headers,
    Header,
};
use Innmind\Filesystem\{
    File\Content,
    Chunk,
};
use Innmind\Immutable\{
    Sequence,
    Str,
};

/**
 * @psalm-immutable
 */
final class Stringable implements ResponseInterface
{
    private ResponseInterface $response;

    public function __construct(ResponseInterface $response)
    {
        $this->response = $response;
    }

    /**
     * @psalm-pure
     */
    public static function of(ResponseInterface $response): self
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
            ->sort(static fn($a, $b) => $b->name() <=> $a->name())
            ->map(static fn($header) => $header->toString())
            ->map(Str::of(...))
            ->map(static fn($header) => $header->append("\n"));
        $body = (new Chunk)($this->body());

        return Content\Chunks::of(
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

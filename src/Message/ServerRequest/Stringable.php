<?php
declare(strict_types = 1);

namespace Innmind\Http\Message\ServerRequest;

use Innmind\Http\{
    ServerRequest,
    Message\Method,
    Message\Environment,
    Message\Cookies,
    Message\Query,
    Message\Form,
    Message\Files,
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
    private ServerRequest $request;

    public function __construct(ServerRequest $request)
    {
        $this->request = $request;
    }

    /**
     * @psalm-pure
     */
    public static function of(ServerRequest $request): self
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

    public function environment(): Environment
    {
        return $this->request->environment();
    }

    public function cookies(): Cookies
    {
        return $this->request->cookies();
    }

    public function query(): Query
    {
        return $this->request->query();
    }

    public function form(): Form
    {
        return $this->request->form();
    }

    public function files(): Files
    {
        return $this->request->files();
    }

    public function asContent(): Content
    {
        $status = Str::of("%s %s%s HTTP/%s\n")->sprintf(
            $this->method()->toString(),
            $this->url()->path()->toString(),
            $this->queryString(),
            $this->protocolVersion()->toString(),
        );
        $headers = $this
            ->headers()
            ->all()
            ->map(static fn($header) => $header->toString())
            ->map(Str::of(...))
            ->map(static fn($header) => $header->append("\n"));

        return Content::ofChunks(
            Sequence::lazyStartingWith($status)
                ->append($headers)
                ->add(Str::of("\n"))
                ->append($this->bodyChunks()),
        );
    }

    public function toString(): string
    {
        return $this->asContent()->toString();
    }

    private function queryString(): string
    {
        if (\count($this->query()) === 0) {
            return '';
        }

        return '?'.\rawurldecode(\http_build_query($this->query()->data()));
    }

    /**
     * @return Sequence<Str>
     */
    private function bodyChunks(): Sequence
    {
        if (\count($this->form()) !== 0) {
            return Sequence::of($this->form()->data())
                ->map(\http_build_query(...))
                ->map(\rawurldecode(...))
                ->map(Str::of(...));
        }

        return $this->body()->chunks();
    }
}

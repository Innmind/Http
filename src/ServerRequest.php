<?php
declare(strict_types = 1);

namespace Innmind\Http;

use Innmind\Http\{
    ServerRequest\Cookies,
    ServerRequest\Query,
    ServerRequest\Form,
    ServerRequest\Files,
};
use Innmind\Url\Url;
use Innmind\Filesystem\File\Content;

/**
 * @psalm-immutable
 */
final class ServerRequest
{
    private function __construct(
        private Url $url,
        private Method $method,
        private ProtocolVersion $protocolVersion,
        private Headers $headers,
        private Content $body,
        private Cookies $cookies,
        private Query $query,
        private Form $form,
        private Files $files,
    ) {
    }

    /**
     * @psalm-pure
     */
    #[\NoDiscard]
    public static function of(
        Url $url,
        Method $method,
        ProtocolVersion $protocolVersion,
        ?Headers $headers = null,
        ?Content $body = null,
        ?Cookies $cookies = null,
        ?Query $query = null,
        ?Form $form = null,
        ?Files $files = null,
    ): self {
        return new self(
            $url,
            $method,
            $protocolVersion,
            $headers ?? Headers::of(),
            $body ?? Content::none(),
            $cookies ?? Cookies::of(),
            $query ?? Query::of([]),
            $form ?? Form::of([]),
            $files ?? Files::of([]),
        );
    }

    #[\NoDiscard]
    public function protocolVersion(): ProtocolVersion
    {
        return $this->protocolVersion;
    }

    #[\NoDiscard]
    public function headers(): Headers
    {
        return $this->headers;
    }

    #[\NoDiscard]
    public function body(): Content
    {
        return $this->body;
    }

    #[\NoDiscard]
    public function url(): Url
    {
        return $this->url;
    }

    #[\NoDiscard]
    public function method(): Method
    {
        return $this->method;
    }

    #[\NoDiscard]
    public function cookies(): Cookies
    {
        return $this->cookies;
    }

    #[\NoDiscard]
    public function query(): Query
    {
        return $this->query;
    }

    #[\NoDiscard]
    public function form(): Form
    {
        return $this->form;
    }

    #[\NoDiscard]
    public function files(): Files
    {
        return $this->files;
    }
}

<?php
declare(strict_types = 1);

namespace Innmind\Http;

use Innmind\Http\{
    ServerRequest\Environment,
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
    private Url $url;
    private Method $method;
    private ProtocolVersion $protocolVersion;
    private Headers $headers;
    private Content $body;
    private Environment $environment;
    private Cookies $cookies;
    private Query $query;
    private Form $form;
    private Files $files;

    private function __construct(
        Url $url,
        Method $method,
        ProtocolVersion $protocolVersion,
        Headers $headers = null,
        Content $body = null,
        Environment $environment = null,
        Cookies $cookies = null,
        Query $query = null,
        Form $form = null,
        Files $files = null,
    ) {
        $this->url = $url;
        $this->method = $method;
        $this->protocolVersion = $protocolVersion;
        $this->headers = $headers ?? Headers::of();
        $this->body = $body ?? Content::none();
        $this->environment = $environment ?? Environment::of();
        $this->cookies = $cookies ?? Cookies::of();
        $this->query = $query ?? Query::of([]);
        $this->form = $form ?? Form::of([]);
        $this->files = $files ?? Files::of([]);
    }

    /**
     * @psalm-pure
     */
    public static function of(
        Url $url,
        Method $method,
        ProtocolVersion $protocolVersion,
        Headers $headers = null,
        Content $body = null,
        Environment $environment = null,
        Cookies $cookies = null,
        Query $query = null,
        Form $form = null,
        Files $files = null,
    ): self {
        return new self(
            $url,
            $method,
            $protocolVersion,
            $headers,
            $body,
            $environment,
            $cookies,
            $query,
            $form,
            $files,
        );
    }

    public function protocolVersion(): ProtocolVersion
    {
        return $this->protocolVersion;
    }

    public function headers(): Headers
    {
        return $this->headers;
    }

    public function body(): Content
    {
        return $this->body;
    }

    public function url(): Url
    {
        return $this->url;
    }

    public function method(): Method
    {
        return $this->method;
    }

    public function environment(): Environment
    {
        return $this->environment;
    }

    public function cookies(): Cookies
    {
        return $this->cookies;
    }

    public function query(): Query
    {
        return $this->query;
    }

    public function form(): Form
    {
        return $this->form;
    }

    public function files(): Files
    {
        return $this->files;
    }
}

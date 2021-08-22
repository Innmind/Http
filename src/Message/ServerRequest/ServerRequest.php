<?php
declare(strict_types = 1);

namespace Innmind\Http\Message\ServerRequest;

use Innmind\Http\{
    Message\ServerRequest as ServerRequestInterface,
    Message\Method,
    Message\Environment,
    Message\Cookies,
    Message\Query,
    Message\Form,
    Message\Files,
    ProtocolVersion,
    Headers,
};
use Innmind\Url\Url;
use Innmind\Filesystem\File\Content;

/**
 * @psalm-immutable
 */
final class ServerRequest implements ServerRequestInterface
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

    public function __construct(
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
        $this->headers = $headers ?? new Headers;
        $this->body = $body ?? Content\Lines::ofContent('');
        $this->environment = $environment ?? new Environment;
        $this->cookies = $cookies ?? new Cookies;
        $this->query = $query ?? new Query;
        $this->form = $form ?? new Form;
        $this->files = $files ?? new Files;
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

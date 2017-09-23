<?php
declare(strict_types = 1);

namespace Innmind\Http\Message\ServerRequest;

use Innmind\Http\{
    Message\ServerRequest as ServerRequestInterface,
    Message\Request\Request,
    Message\Message,
    Message\Method,
    Message\Environment,
    Message\Cookies,
    Message\Query,
    Message\Form,
    Message\Files,
    ProtocolVersion,
    Headers
};
use Innmind\Url\UrlInterface;
use Innmind\Filesystem\{
    StreamInterface,
    Stream\NullStream
};

final class ServerRequest extends Request implements ServerRequestInterface
{
    private $environment;
    private $cookies;
    private $query;
    private $form;
    private $files;

    public function __construct(
        UrlInterface $url,
        Method $method,
        ProtocolVersion $protocolVersion,
        Headers $headers = null,
        StreamInterface $body = null,
        Environment $environment = null,
        Cookies $cookies = null,
        Query $query = null,
        Form $form = null,
        Files $files = null
    ) {
        parent::__construct(
            $url,
            $method,
            $protocolVersion,
            $headers ?? new Headers\Headers,
            $body ?? new NullStream
        );

        $this->environment = $environment ?? new Environment\Environment;
        $this->cookies = $cookies ?? new Cookies\Cookies;
        $this->query = $query ?? new Query\Query;
        $this->form = $form ?? new Form\Form;
        $this->files = $files ?? new Files\Files;
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
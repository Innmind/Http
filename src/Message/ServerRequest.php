<?php
declare(strict_types = 1);

namespace Innmind\Http\Message;

use Innmind\Http\{
    Message,
    ProtocolVersionInterface,
    HeadersInterface,
    Headers,
    Message\Environment,
    Message\Cookies,
    Message\Query,
    Message\Form,
    Message\Files
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
        MethodInterface $method,
        ProtocolVersionInterface $protocolVersion,
        HeadersInterface $headers = null,
        StreamInterface $body = null,
        EnvironmentInterface $environment = null,
        CookiesInterface $cookies = null,
        QueryInterface $query = null,
        FormInterface $form = null,
        FilesInterface $files = null
    ) {
        parent::__construct(
            $url,
            $method,
            $protocolVersion,
            $headers ?? new Headers,
            $body ?? new NullStream
        );

        $this->environment = $environment ?? new Environment;
        $this->cookies = $cookies ?? new Cookies;
        $this->query = $query ?? new Query;
        $this->form = $form ?? new Form;
        $this->files = $files ?? new Files;
    }

    public function environment(): EnvironmentInterface
    {
        return $this->environment;
    }

    public function cookies(): CookiesInterface
    {
        return $this->cookies;
    }

    public function query(): QueryInterface
    {
        return $this->query;
    }

    public function form(): FormInterface
    {
        return $this->form;
    }

    public function files(): FilesInterface
    {
        return $this->files;
    }
}

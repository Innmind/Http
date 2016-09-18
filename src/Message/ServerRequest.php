<?php
declare(strict_types = 1);

namespace Innmind\Http\Message;

use Innmind\Http\{
    Message,
    ProtocolVersionInterface,
    HeadersInterface
};
use Innmind\Url\UrlInterface;
use Innmind\Filesystem\StreamInterface;

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
        HeadersInterface $headers,
        StreamInterface $body,
        EnvironmentInterface $environment,
        CookiesInterface $cookies,
        QueryInterface $query,
        FormInterface $form,
        FilesInterface $files
    ) {
        parent::__construct($url, $method, $protocolVersion, $headers, $body);

        $this->environment = $environment;
        $this->cookies = $cookies;
        $this->query = $query;
        $this->form = $form;
        $this->files = $files;
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

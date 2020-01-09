<?php
declare(strict_types = 1);

namespace Innmind\Http\Message\Request;

use Innmind\Http\{
    Message\Request as RequestInterface,
    Message\Method,
    ProtocolVersion,
    Headers,
    Header,
};
use Innmind\Url\UrlInterface;
use Innmind\Stream\Readable;

final class Stringable implements RequestInterface
{
    private $request;

    public function __construct(RequestInterface $request)
    {
        $this->request = $request;
    }

    public function url(): UrlInterface
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

    public function body(): Readable
    {
        return $this->request->body();
    }

    public function toString(): string
    {
        $headers = \iterator_to_array($this->headers());
        $headers = \array_map(fn(Header $header): string => $header->toString(), $headers);
        $headers = \implode("\n", $headers);

        return <<<RAW
{$this->method()->toString()} {$this->url()} HTTP/{$this->protocolVersion()->toString()}
$headers

{$this->body()}
RAW;
    }
}

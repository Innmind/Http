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
use Innmind\Url\Url;
use Innmind\Filesystem\File\Content;

/**
 * @psalm-immutable
 */
final class Stringable implements RequestInterface
{
    private RequestInterface $request;

    public function __construct(RequestInterface $request)
    {
        $this->request = $request;
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

    public function toString(): string
    {
        $headers = $this->headers()->reduce(
            [],
            static function(array $headers, Header $header): array {
                $headers[] = $header;

                return $headers;
            },
        );
        $headers = \array_map(static fn(Header $header): string => $header->toString(), $headers);
        $headers = \implode("\n", $headers);

        return <<<RAW
{$this->method()->toString()} {$this->url()->toString()} HTTP/{$this->protocolVersion()->toString()}
$headers

{$this->body()->toString()}
RAW;
    }
}

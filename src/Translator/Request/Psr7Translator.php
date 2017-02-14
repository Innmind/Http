<?php
declare(strict_types = 1);

namespace Innmind\Http\Translator\Request;

use Innmind\Http\{
    Factory\HeaderFactoryInterface,
    Message\Request,
    Message\Method,
    ProtocolVersion,
    Headers,
    Header\HeaderInterface
};
use Innmind\Url\Url;
use Innmind\Filesystem\Stream\StringStream;
use Innmind\Immutable\{
    Map,
    Str
};
use Psr\Http\Message\RequestInterface;

final class Psr7Translator
{
    private $headerFactory;

    public function __construct(HeaderFactoryInterface $headerFactory)
    {
        $this->headerFactory = $headerFactory;
    }

    public function translate(RequestInterface $request): Request
    {
        list($major, $minor) = explode('.', $request->getProtocolVersion());

        return new Request(
            Url::fromString((string) $request->getUri()),
            new Method(strtoupper($request->getMethod())),
            new ProtocolVersion((int) $major, (int) $minor),
            $this->translateHeaders($request->getHeaders()),
            new StringStream((string) $request->getBody())
        );
    }

    private function translateHeaders(array $rawHeaders): Headers
    {
        $headers = new Map('string', HeaderInterface::class);

        foreach ($rawHeaders as $name => $values) {
            $header = $this->headerFactory->make(
                new Str($name),
                new Str(implode(', ', $values))
            );
            $headers = $headers->put(
                $header->name(),
                $header
            );
        }

        return new Headers($headers);
    }
}

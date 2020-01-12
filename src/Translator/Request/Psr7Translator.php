<?php
declare(strict_types = 1);

namespace Innmind\Http\Translator\Request;

use Innmind\Http\{
    Factory\HeaderFactory,
    Message\Request\Request,
    Message\Method,
    ProtocolVersion,
    Headers,
    Header,
};
use Innmind\Url\Url;
use Innmind\Stream\Readable\Stream;
use Innmind\Immutable\{
    Map,
    Str,
};
use Psr\Http\Message\RequestInterface;

final class Psr7Translator
{
    private HeaderFactory $headerFactory;

    public function __construct(HeaderFactory $headerFactory)
    {
        $this->headerFactory = $headerFactory;
    }

    public function __invoke(RequestInterface $request): Request
    {
        [$major, $minor] = \explode('.', $request->getProtocolVersion());

        return new Request(
            Url::of((string) $request->getUri()),
            new Method(\strtoupper($request->getMethod())),
            new ProtocolVersion((int) $major, (int) $minor),
            $this->translateHeaders($request->getHeaders()),
            Stream::ofContent((string) $request->getBody()),
        );
    }

    private function translateHeaders(array $rawHeaders): Headers
    {
        $headers = [];

        foreach ($rawHeaders as $name => $values) {
            $headers[] = ($this->headerFactory)(
                Str::of($name),
                Str::of(\implode(', ', $values)),
            );
        }

        return new Headers(...$headers);
    }
}

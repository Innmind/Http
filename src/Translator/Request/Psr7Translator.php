<?php
declare(strict_types = 1);

namespace Innmind\Http\Translator\Request;

use Innmind\Http\{
    Factory\HeaderFactory,
    Factory\Header\Factories,
    Message\Request\Request,
    Message\Method,
    ProtocolVersion,
    Headers,
    Header,
    Bridge\Psr7\Stream,
};
use Innmind\TimeContinuum\Clock;
use Innmind\Url\Url;
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
            Method::of(\strtoupper($request->getMethod())),
            new ProtocolVersion((int) $major, (int) $minor),
            $this->translateHeaders($request->getHeaders()),
            new Stream($request->getBody()),
        );
    }

    public static function default(Clock $clock): self
    {
        return new self(Factories::default($clock));
    }

    private function translateHeaders(array $rawHeaders): Headers
    {
        $headers = [];

        /**
         * @var string $name
         * @var array<string> $values
         */
        foreach ($rawHeaders as $name => $values) {
            $headers[] = ($this->headerFactory)(
                Str::of($name),
                Str::of(\implode(', ', $values)),
            );
        }

        return new Headers(...$headers);
    }
}

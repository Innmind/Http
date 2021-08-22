<?php
declare(strict_types = 1);

namespace Innmind\Http\Translator\Response;

use Innmind\Http\{
    Factory\HeaderFactory,
    Factory\Header\Factories,
    Factory\Header\TryFactory,
    Message\Response\Response,
    Message\StatusCode,
    Message\ReasonPhrase,
    ProtocolVersion,
    Headers,
    Header,
    Stream,
};
use Innmind\Filesystem\File\Content;
use Innmind\TimeContinuum\Clock;
use Innmind\Immutable\{
    Map,
    Str,
};
use Psr\Http\Message\ResponseInterface;

final class FromPsr7
{
    private TryFactory $headerFactory;

    public function __construct(HeaderFactory $headerFactory)
    {
        $this->headerFactory = new TryFactory($headerFactory);
    }

    public function __invoke(ResponseInterface $response): Response
    {
        [$major, $minor] = \explode('.', $response->getProtocolVersion());

        return new Response(
            new StatusCode($code = $response->getStatusCode()),
            ReasonPhrase::of($code),
            new ProtocolVersion((int) $major, (int) $minor),
            $this->translateHeaders($response->getHeaders()),
            Content\OfStream::of(new Stream\FromPsr7($response->getBody())),
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

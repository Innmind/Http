<?php
declare(strict_types = 1);

namespace Innmind\Http;

use Innmind\Http\{
    Message\Response,
    Header\Date,
    Header\DateValue,
    Exception\LogicException
};
use Innmind\TimeContinuum\TimeContinuumInterface;

final class ResponseSender implements Sender
{
    private $clock;

    public function __construct(TimeContinuumInterface $clock)
    {
        $this->clock = $clock;
    }

    public function __invoke(Response $response): void
    {
        if (headers_sent()) {
            throw new LogicException('Headers already sent');
        }

        header(sprintf(
            'HTTP/%s %s %s',
            $response->protocolVersion(),
            $response->statusCode(),
            $response->reasonPhrase()
        ));

        if (!$response->headers()->has('date')) {
            header((string) new Date(new DateValue($this->clock->now())));
        }

        foreach ($response->headers() as $header) {
            header((string) $header, false);
        }

        $body = $response->body();
        $body->rewind();

        while (!$body->end()) {
            echo $body->read(4096);
            flush();
        }

        if (function_exists('fastcgi_finish_request')) {
            fastcgi_finish_request();
        }
    }
}

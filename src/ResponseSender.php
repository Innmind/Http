<?php
declare(strict_types = 1);

namespace Innmind\Http;

use Innmind\Http\{
    Message\Response,
    Header\Date,
    Header\DateValue
};
use Innmind\TimeContinuum\TimeContinuumInterface;

final class ResponseSender
{
    private $clock;

    public function __construct(TimeContinuumInterface $clock)
    {
        $this->clock = $clock;
    }

    /**
     * @return void
     */
    public function send(Response $response)
    {
        header(sprintf(
            'HTTP/%s %s %s',
            $response->protocolVersion(),
            $response->statusCode(),
            $response->reasonPhrase()
        ));

        if (!$response->headers()->has('date')) {
            header((string) new Date(new DateValue($this->clock->now())));
        }

        $response
            ->headers()
            ->foreach(static function(Header $header): void {
                header((string) $header, false);
            });

        echo (string) $response->body();

        if (function_exists('fastcgi_finish_request')) {
            fastcgi_finish_request();
        }
    }
}

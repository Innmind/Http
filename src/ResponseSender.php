<?php
declare(strict_types = 1);

namespace Innmind\Http;

use Innmind\Http\{
    Message\ResponseInterface,
    Header\Date,
    Header\DateValue
};

final class ResponseSender
{
    /**
     * @return void
     */
    public function send(ResponseInterface $response)
    {
        header(sprintf(
            'HTTP/%s %s %s',
            $response->protocolVersion(),
            $response->statusCode(),
            $response->reasonPhrase()
        ));

        if (!$response->headers()->has('date')) {
            header((string) new Date(new DateValue(new \DateTime)));
        }

        foreach ($response->headers() as $header) {
            header((string) $header, false);
        }

        echo (string) $response->body();

        if (function_exists('fastcgi_finish_request')) {
            fastcgi_finish_request();
        }
    }
}
<?php
declare(strict_types = 1);

namespace Innmind\Http;

use Innmind\Http\{
    Message\Response,
    Header\Date,
    Header\DateValue,
    Header\SetCookie,
    Header\CookieValue,
    Header\Parameter,
    TimeContinuum\Format\Http,
    Exception\LogicException
};
use Innmind\TimeContinuum\Clock;

final class ResponseSender implements Sender
{
    private Clock $clock;

    public function __construct(Clock $clock)
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
        ), true, $response->statusCode()->value());

        if (!$response->headers()->contains('date')) {
            header((string) new Date(new DateValue($this->clock->now())));
        }

        $response->headers()->foreach(function($header): void {
            if ($header instanceof SetCookie) {
                $this->sendCookie($header);
                continue;
            }

            header((string) $header, false);
        });

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

    private function sendCookie(SetCookie $cookie): void
    {
        $cookie->values()->foreach(static function(CookieValue $value): void {
            $parameters = $value->parameters()->reduce(
                [],
                static function(array $parameters, string $name, Parameter $parameter): array {
                    switch ($parameter->name()) {
                        case 'Domain':
                            $parameters['domain'] = $parameter->value();
                            break;

                        case 'Expires':
                            $timestamp = \DateTimeImmutable::createFromFormat(
                                (string) new Http,
                                substr($parameter->value(), 1, -1) // remove double quotes
                            )->getTimestamp();
                            // MaxAge has precedence
                            $parameters['expire'] = ($parameters['expire'] ?? 0 !== 0) ? $parameters['expire'] : $timestamp;
                            break;

                        case 'Max-Age':
                            $parameters['expire'] = (int) $parameter->value();
                            break;

                        case 'HttpOnly':
                            $parameters['httponly'] = true;
                            break;

                        case 'Path':
                            $parameters['path'] = $parameter->value();
                            break;

                        case 'Secure':
                            $parameters['secure'] = true;
                            break;

                        case 'SameSite':
                            $parameters['samesite'] = $parameter->value();
                            break;

                        default:
                            $parameters['key'] = $parameter->name();
                            $parameters['value'] = $parameter->value();
                            break;
                    }

                    return $parameters;
                }
            );

            if (\PHP_VERSION_ID >= 70300) {
                $options = [
                    'path' => $parameters['path'] ?? '',
                    'domain' => $parameters['domain'] ?? '',
                    'secure' => $parameters['secure'] ?? false,
                    'httponly' => $parameters['httponly'] ?? false,
                ];

                if (isset($parameters['samesite'])) {
                    $options['samesite'] = $parameters['samesite'];
                }

                setcookie(
                    $parameters['key'] ?? '',
                    $parameters['value'] ?? '',
                    $parameters['expire'] ?? 0,
                    $options
                );
            } else {
                // same site not supported
                setcookie(
                    $parameters['key'] ?? '',
                    $parameters['value'] ?? '',
                    $parameters['expire'] ?? 0,
                    $parameters['path'] ?? '',
                    $parameters['domain'] ?? '',
                    $parameters['secure'] ?? false,
                    $parameters['httponly'] ?? false
                );
            }
        });
    }
}

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
    Exception\LogicException,
};
use Innmind\TimeContinuum\Clock;
use Innmind\Filesystem\{
    Chunk,
    File,
};
use Innmind\Immutable\{
    Sequence,
    Str,
};

final class ResponseSender implements Sender
{
    private Clock $clock;
    /** @var callable(File\Content): Sequence<Str> */
    private $chunk;

    /**
     * @param callable(File\Content): Sequence<Str> $chunk
     */
    public function __construct(Clock $clock, callable $chunk = null)
    {
        $this->clock = $clock;
        $this->chunk = $chunk ?? new Chunk;
    }

    public function __invoke(Response $response): void
    {
        if (\headers_sent()) {
            throw new LogicException('Headers already sent');
        }

        \header(
            \sprintf(
                'HTTP/%s %s %s',
                $response->protocolVersion()->toString(),
                $response->statusCode()->toString(),
                $response->statusCode()->reasonPhrase(),
            ),
            true,
            $response->statusCode()->toInt(),
        );

        $headers = $response->headers();
        $headers = $headers
            ->get('date')
            ->match(
                static fn() => $headers,
                fn() => ($headers)(Date::of($this->clock->now())),
            );

        $_ = $headers->foreach(function(Header $header): void {
            if ($header instanceof SetCookie) {
                $this->sendCookie($header);

                return;
            }

            \header($header->toString(), false);
        });

        $_ = ($this->chunk)($response->body())->foreach(static function($chunk): void {
            echo $chunk->toString();
            \flush();
        });

        if (\function_exists('fastcgi_finish_request')) {
            fastcgi_finish_request();
        }
    }

    private function sendCookie(SetCookie $cookie): void
    {
        $_ = $cookie->cookies()->foreach(static function(CookieValue $value): void {
            $parameters = $value->parameters()->values()->reduce(
                [],
                static function(array $parameters, Parameter $parameter): array {
                    switch ($parameter->name()) {
                        case 'Domain':
                            $parameters['domain'] = $parameter->value();
                            break;

                        case 'Expires':
                            /** @psalm-suppress PossiblyFalseReference Expires object uses a valid date */
                            $timestamp = \DateTimeImmutable::createFromFormat(
                                (new Http)->toString(),
                                \substr($parameter->value(), 1, -1), // remove double quotes
                            )->getTimestamp();
                            // MaxAge has precedence
                            /** @psalm-suppress MixedAssignment */
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
                },
            );

            $options = [
                'path' => $parameters['path'] ?? '',
                'domain' => $parameters['domain'] ?? '',
                'secure' => $parameters['secure'] ?? false,
                'httponly' => $parameters['httponly'] ?? false,
            ];

            if (isset($parameters['samesite'])) {
                /** @psalm-suppress MixedAssignment */
                $options['samesite'] = $parameters['samesite'];
            }

            /**
             * @psalm-suppress MixedArgument
             * @psalm-suppress InvalidArgument
             * @psalm-suppress InvalidCast
             */
            \setcookie(
                $parameters['key'] ?? '',
                $parameters['value'] ?? '',
                $parameters['expire'] ?? 0,
                $options,
            );
        });
    }
}

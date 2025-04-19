<?php
declare(strict_types = 1);

namespace Innmind\Http;

use Innmind\Http\{
    Header\Date,
    Header\SetCookie,
    Header\CookieValue,
    Header\Parameter,
    TimeContinuum\Format\Http,
    Exception\LogicException,
};
use Innmind\TimeContinuum\Clock;
use Innmind\Immutable\{
    Attempt,
    SideEffect,
};

final class ResponseSender implements Sender
{
    public function __construct(
        private Clock $clock,
    ) {
    }

    #[\Override]
    public function __invoke(Response $response): Attempt
    {
        if (\headers_sent()) {
            return Attempt::error(new LogicException('Headers already sent'));
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

        $_ = $headers->foreach(function($header): void {
            if ($header instanceof SetCookie) {
                $this->sendCookie($header);

                return;
            }

            if ($header instanceof Header\Provider) {
                $header = $header->toHeader();
            }

            \header($header->toString(), false);
        });

        $_ = $response
            ->body()
            ->chunks()
            ->foreach(static function($chunk): void {
                echo $chunk->toString();
                \flush();
            });

        if (\function_exists('fastcgi_finish_request')) {
            fastcgi_finish_request();
        }

        return Attempt::result(SideEffect::identity());
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
                                Http::new()->toString(),
                                \substr($parameter->value(), 1, -1), // remove double quotes
                            )->getTimestamp();
                            // MaxAge has precedence
                            /** @psalm-suppress MixedAssignment */
                            $parameters['expire'] = match ($parameters['expire'] ?? 0) {
                                0 => $timestamp,
                                default => $parameters['expire'] ?? 0,
                            };
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

<?php
declare(strict_types = 1);

namespace Innmind\Http\Response\Sender;

use Innmind\Http\{
    Response,
    Header\Custom,
    Header\Date,
    Header\SetCookie,
    Exception\LogicException,
};
use Innmind\TimeContinuum\{
    Clock,
    Format,
};
use Innmind\Immutable\{
    Map,
    Attempt,
    SideEffect,
};

final class Native implements Response\Sender
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

            if ($header instanceof Custom) {
                $header = $header->normalize();
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
        $_ = $cookie->cookies()->foreach(static function(SetCookie $cookie): void {
            $parameters = $cookie->parameters()->map(
                static fn($parameter) => match (true) {
                    $parameter === SetCookie\Directive::httpOnly => ['httponly', true],
                    $parameter === SetCookie\Directive::secure => ['secure', true],
                    $parameter === SetCookie\Directive::laxSameSite => ['samesite', 'Lax'],
                    $parameter === SetCookie\Directive::strictSameSite => ['samesite', 'Strict'],
                    $parameter instanceof SetCookie\Domain => ['domain', $parameter->host()->toString()],
                    $parameter instanceof SetCookie\Expires => [
                        'expires',
                        (int) $parameter->date()->format(Format::of('U')),
                    ],
                    $parameter instanceof SetCookie\MaxAge => ['max-age', $parameter->toInt()],
                    $parameter instanceof SetCookie\Path => ['path', $parameter->path()->toString()],
                },
            );

            $parameters = Map::of(...$parameters->toList());
            // Max age has precedence over expire
            $parameters = $parameters->get('max-age')->match(
                static fn($value) => ($parameters)('expires', $value),
                static fn() => $parameters,
            );
            $options = $parameters->reduce(
                [],
                static function(array $options, $key, $value) {
                    $options[$key] = $value;

                    return $options;
                },
            );

            \setcookie(
                $cookie->name(),
                $cookie->value(),
                $options,
            );
        });
    }
}

<?php
declare(strict_types = 1);

namespace Innmind\Http\Message\ServerRequest;

use Innmind\Http\{
    Message\ServerRequest as ServerRequestInterface,
    Message\Method,
    Message\Environment,
    Message\Cookies,
    Message\Query,
    Message\Form,
    Message\Files,
    ProtocolVersion,
    Headers,
    Header,
};
use Innmind\Url\Url;
use Innmind\Stream\Readable;

final class Stringable implements ServerRequestInterface
{
    private ServerRequestInterface $request;

    public function __construct(ServerRequestInterface $request)
    {
        $this->request = $request;
    }

    public function url(): Url
    {
        return $this->request->url();
    }

    public function method(): Method
    {
        return $this->request->method();
    }

    public function protocolVersion(): ProtocolVersion
    {
        return $this->request->protocolVersion();
    }

    public function headers(): Headers
    {
        return $this->request->headers();
    }

    public function body(): Readable
    {
        return $this->request->body();
    }

    public function environment(): Environment
    {
        return $this->request->environment();
    }

    public function cookies(): Cookies
    {
        return $this->request->cookies();
    }

    public function query(): Query
    {
        return $this->request->query();
    }

    public function form(): Form
    {
        return $this->request->form();
    }

    public function files(): Files
    {
        return $this->request->files();
    }

    public function toString(): string
    {
        $headers = $this->headers()->reduce(
            [],
            static function(array $headers, Header $header): array {
                $headers[] = $header;

                return $headers;
            },
        );
        $headers = \array_map(
            static fn(Header $header): string => $header->toString(),
            $headers,
        );
        $headers = \implode("\n", $headers);

        return <<<RAW
{$this->method()->toString()} {$this->url()->path()->toString()}{$this->queryString()} HTTP/{$this->protocolVersion()->toString()}
$headers

{$this->bodyString()}
RAW;
    }

    private function queryString(): string
    {
        if (\count($this->query()) === 0) {
            return '';
        }

        /** @var list<Query\Parameter> */
        $parameters = $this->query()->reduce(
            [],
            static function(array $parameters, Query\Parameter $parameter): array {
                $parameters[] = $parameter;

                return $parameters;
            },
        );
        $query = [];

        foreach ($parameters as $parameter) {
            /** @psalm-suppress MixedAssignment */
            $query[$parameter->name()] = $parameter->value();
        }

        return '?'.\rawurldecode(\http_build_query($query));
    }

    private function bodyString(): string
    {
        if ($this->body()->knowsSize() && $this->body()->size()->toInt() > 0) {
            return $this->body()->toString();
        }

        if (\count($this->form()) === 0) {
            return '';
        }

        /** @var list<Form\Parameter> */
        $parameters = $this->form()->reduce(
            [],
            static function(array $parameters, Form\Parameter $parameter): array {
                $parameters[] = $parameter;

                return $parameters;
            },
        );
        $form = [];

        foreach ($parameters as $parameter) {
            $form[$parameter->name()] = $parameter->value();
        }

        return \rawurldecode(\http_build_query($form));
    }
}

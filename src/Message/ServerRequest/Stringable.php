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
    Headers
};
use Innmind\Url\UrlInterface;
use Innmind\Stream\Readable;
use Innmind\Immutable\MapInterface;

final class Stringable implements ServerRequestInterface
{
    private $request;

    public function __construct(ServerRequestInterface $request)
    {
        $this->request = $request;
    }

    public function url(): UrlInterface
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

    public function __toString(): string
    {
        $headers = \iterator_to_array($this->headers());
        $headers = \implode("\n", $headers);

        return <<<RAW
{$this->method()} {$this->url()->path()}{$this->queryString()} HTTP/{$this->protocolVersion()}
$headers

{$this->bodyString()}
RAW;
    }

    private function queryString(): string
    {
        if (\count($this->query()) === 0) {
            return '';
        }

        $parameters = \iterator_to_array($this->query());
        $query = [];

        foreach ($parameters as $parameter) {
            $query[$parameter->name()] = $parameter->value();
        }

        return '?'.\rawurldecode(\http_build_query($query));
    }

    private function bodyString(): string
    {
        if ($this->body()->knowsSize() && $this->body()->size()->toInt() > 0) {
            return (string) $this->body();
        }

        if (\count($this->form()) === 0) {
            return '';
        }

        $parameters = \iterator_to_array($this->form());
        $form = [];

        foreach ($parameters as $parameter) {
            $form[$parameter->name()] = $this->decodeFormParameter(
                $parameter->value()
            );
        }

        return \rawurldecode(\http_build_query($form));
    }

    private function decodeFormParameter($value)
    {
        if ($value instanceof MapInterface) {
            return $value->reduce(
                [],
                function(array $values, $key, $parameter): array {
                    $values[$key] = $this->decodeFormParameter($parameter->value());

                    return $values;
                }
            );
        }

        return $value;
    }
}

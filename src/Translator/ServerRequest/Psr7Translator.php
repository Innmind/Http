<?php
declare(strict_types = 1);

namespace Innmind\Http\Translator\ServerRequest;

use Innmind\Http\{
    Translator\Request\Psr7Translator as RequestTranslator,
    Message\ServerRequest,
    Message\Files,
    Message\Environment,
    Message\Cookies,
    Message\Query,
    Message\Query\ParameterInterface as QueryParameterInterface,
    Message\Query\Parameter as QueryParameter,
    Message\Form,
    Message\Form\ParameterInterface as FormParameterInterface,
    Message\Form\Parameter as FormParameter,
    File\FileInterface
};
use Innmind\Immutable\Map;
use Psr\Http\Message\ServerRequestInterface;

final class Psr7Translator
{
    private $requestTranslator;

    public function __construct(RequestTranslator $requestTranslator)
    {
        $this->requestTranslator = $requestTranslator;
    }

    public function translate(ServerRequestInterface $serverRequest): ServerRequest
    {
        $request = $this->requestTranslator->translate($serverRequest);

        return new ServerRequest(
            $request->url(),
            $request->method(),
            $request->protocolVersion(),
            $request->headers(),
            $request->body(),
            $this->translateEnvironment($serverRequest->getServerParams()),
            $this->translateCookies($serverRequest->getCookieParams()),
            $this->translateQuery($serverRequest->getQueryParams()),
            $this->translateForm($serverRequest->getParsedBody()),
            new Files(new Map('string', FileInterface::class)) //can't be translated as raw data is not accessible
        );
    }

    private function translateEnvironment(array $params): Environment
    {
        $map = new Map('string', 'scalar');

        foreach ($params as $key => $value) {
            if (is_scalar($value)) {
                $map = $map->put($key, $value);
            }
        }

        return new Environment($map);
    }

    private function translateCookies(array $params): Cookies
    {
        $map = new Map('string', 'scalar');

        foreach ($params as $key => $value) {
            if (is_scalar($value)) {
                $map = $map->put($key, $value);
            }
        }

        return new Cookies($map);
    }

    private function translateQuery(array $params): Query
    {
        $map = new Map('string', QueryParameterInterface::class);

        foreach ($params as $key => $value) {
            if (is_scalar($value)) {
                $map = $map->put(
                    $key,
                    new QueryParameter($key, $value)
                );
            }
        }

        return new Query($map);
    }

    private function translateForm(array $params): Form
    {
        $map = new Map('scalar', FormParameterInterface::class);

        foreach ($params as $key => $value) {
            if (is_scalar($value)) {
                $map = $map->put(
                    $key,
                    new FormParameter($key, $value)
                );
            }
        }

        return new Form($map);
    }
}

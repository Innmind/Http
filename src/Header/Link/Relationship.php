<?php
declare(strict_types = 1);

namespace Innmind\Http\Header\Link;

use Innmind\Http\Header\Parameter;
use Innmind\Url\Url;
use Innmind\Immutable\{
    Str,
    Map,
};

/**
 * @psalm-immutable
 */
final class Relationship
{
    /**
     * @param non-empty-string $rel
     * @param Map<string, Parameter> $parameters
     */
    private function __construct(
        private Url $url,
        private string $rel,
        private Map $parameters,
    ) {
    }

    /**
     * @psalm-pure
     *
     * @param ?non-empty-string $rel
     */
    public static function of(
        Url $url,
        ?string $rel = null,
        Parameter ...$parameters,
    ): self {
        /** @var Map<string, Parameter> */
        $map = Map::of();

        foreach ($parameters as $parameter) {
            $map = ($map)(
                $parameter->name(),
                $parameter,
            );
        }

        return new self($url, $rel ?? 'related', $map);
    }

    public function url(): Url
    {
        return $this->url;
    }

    public function kind(): string
    {
        return $this->rel;
    }

    /**
     * @return Map<string, Parameter>
     */
    public function parameters(): Map
    {
        return $this->parameters;
    }

    public function toString(): string
    {
        $parameters = $this->parameters->values()->map(
            static fn($paramater) => $paramater->toString(),
        );
        $parameters = Str::of(';')->join($parameters);
        $parameters = !$parameters->empty() ? $parameters->prepend(';') : $parameters;
        $link = Str::of('<%s>; rel="%s"')->sprintf($this->url->toString(), $this->rel);

        return $link
            ->append($parameters->toString())
            ->toString();
    }
}

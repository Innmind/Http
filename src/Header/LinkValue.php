<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Exception\DomainException;
use Innmind\Url\Url;
use Innmind\Immutable\{
    Str,
    Map,
};
use function Innmind\Immutable\unwrap;

final class LinkValue extends Value\Value
{
    private Url $url;
    private string $rel;
    private Map $parameters;

    public function __construct(
        Url $url,
        string $rel = null,
        Parameter ...$parameters
    ) {
        $rel = $rel ?? 'related';
        $this->parameters = Map::of('string', Parameter::class);

        if (empty($rel)) {
            throw new DomainException;
        }

        foreach ($parameters as $parameter) {
            $this->parameters = $this->parameters->put(
                $parameter->name(),
                $parameter,
            );
        }

        $this->url = $url;
        $this->rel = $rel;

        $parameters = Str::of(\implode(
            ';',
            \array_map(
                fn(Parameter $paramater): string => $paramater->toString(),
                unwrap($this->parameters->values()),
            ),
        ));
        $parameters = $parameters->length() > 0 ? $parameters->prepend(';') : $parameters;
        $link = Str::of('<%s>; rel="%s"')->sprintf($url->toString(), $rel);

        parent::__construct(
            $link
                ->append($parameters->toString())
                ->toString(),
        );
    }

    public function url(): Url
    {
        return $this->url;
    }

    public function relationship(): string
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
}

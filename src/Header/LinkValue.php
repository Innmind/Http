<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Exception\DomainException;
use Innmind\Url\Url;
use Innmind\Immutable\{
    Str,
    Map,
    Sequence,
};
use function Innmind\Immutable\join;

final class LinkValue extends Value\Value
{
    private Url $url;
    private string $rel;
    /** @var Map<string, Parameter> */
    private Map $parameters;

    public function __construct(
        Url $url,
        string $rel = null,
        Parameter ...$parameters
    ) {
        $rel = $rel ?? 'related';
        /** @var Map<string, Parameter> */
        $this->parameters = Map::of('string', Parameter::class);

        if (empty($rel)) {
            throw new DomainException('Relation can\'t be empty');
        }

        foreach ($parameters as $parameter) {
            $this->parameters = ($this->parameters)(
                $parameter->name(),
                $parameter,
            );
        }

        $this->url = $url;
        $this->rel = $rel;

        /** @var Sequence<string> */
        $parameters = $this->parameters->values()->toSequenceOf(
            'string',
            static fn(Parameter $paramater): \Generator => yield $paramater->toString(),
        );
        $parameters = join(';', $parameters);
        $parameters = !$parameters->empty() ? $parameters->prepend(';') : $parameters;
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

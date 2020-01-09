<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Exception\DomainException;
use Innmind\Url\UrlInterface;
use Innmind\Immutable\{
    Str,
    MapInterface,
    Map
};

final class LinkValue extends Value\Value
{
    private $url;
    private $rel;
    private $parameters;

    public function __construct(
        UrlInterface $url,
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

        $parameters = $this->parameters->values()->join(';');
        $parameters = $parameters->length() > 0 ? $parameters->prepend(';') : $parameters;
        $link = (new Str('<%s>; rel="%s"'))->sprintf((string) $url, $rel);

        parent::__construct((string) $link->append((string) $parameters));
    }

    public function url(): UrlInterface
    {
        return $this->url;
    }

    public function relationship(): string
    {
        return $this->rel;
    }

    /**
     * @return MapInterface<string, Parameter>
     */
    public function parameters(): MapInterface
    {
        return $this->parameters;
    }
}

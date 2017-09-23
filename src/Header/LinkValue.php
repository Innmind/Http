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

final class LinkValue extends HeaderValue\HeaderValue
{
    private $url;
    private $rel;
    private $parameters;

    public function __construct(
        UrlInterface $url,
        string $rel = null,
        MapInterface $parameters = null
    ) {
        $rel = $rel ?? 'related';
        $parameters = $parameters ?? new Map('string', Parameter::class);

        if (empty($rel)) {
            throw new DomainException;
        }

        if (
            (string) $parameters->keyType() !== 'string' ||
            (string) $parameters->valueType() !== Parameter::class
        ) {
            throw new \TypeError(sprintf(
                'Argument 3 must be of type MapInterface<string, %s>',
                Parameter::class
            ));
        }

        $this->url = $url;
        $this->rel = $rel;
        $this->parameters = $parameters;

        $parameters = $parameters
            ->values()
            ->join(';');
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

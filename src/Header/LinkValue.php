<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Exception\InvalidArgumentException;
use Innmind\Url\UrlInterface;
use Innmind\Immutable\{
    StringPrimitive as Str,
    MapInterface
};

final class LinkValue extends HeaderValue
{
    private $url;
    private $rel;
    private $parameters;

    public function __construct(
        UrlInterface $url,
        string $rel,
        MapInterface $parameters
    ) {
        if (
            empty($rel) ||
            (string) $parameters->keyType() !== 'string' ||
            (string) $parameters->valueType() !== ParameterInterface::class
        ) {
            throw new InvalidArgumentException;
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
     * @return MapInterface<string, ParameterInterface>
     */
    public function parameters(): MapInterface
    {
        return $this->parameters;
    }
}

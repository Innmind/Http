<?php
declare(strict_types = 1);

namespace Innmind\Http\Header\CookieParameter;

use Innmind\Http\Header\Parameter;
use Innmind\Url\Path as UrlPath;

/**
 * @psalm-immutable
 */
final class Path implements Parameter
{
    private Parameter $parameter;

    public function __construct(UrlPath $path)
    {
        $this->parameter = new Parameter\Parameter('Path', $path->toString());
    }

    #[\Override]
    public function name(): string
    {
        return $this->parameter->name();
    }

    #[\Override]
    public function value(): string
    {
        return $this->parameter->value();
    }

    #[\Override]
    public function toString(): string
    {
        return $this->parameter->toString();
    }
}

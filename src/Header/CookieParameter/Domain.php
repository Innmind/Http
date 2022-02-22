<?php
declare(strict_types = 1);

namespace Innmind\Http\Header\CookieParameter;

use Innmind\Http\Header\Parameter;
use Innmind\Url\Authority\Host;

/**
 * @psalm-immutable
 */
final class Domain implements Parameter
{
    private Parameter $parameter;

    public function __construct(Host $host)
    {
        $this->parameter = new Parameter\Parameter('Domain', $host->toString());
    }

    public function name(): string
    {
        return $this->parameter->name();
    }

    public function value(): string
    {
        return $this->parameter->value();
    }

    public function toString(): string
    {
        return $this->parameter->toString();
    }
}

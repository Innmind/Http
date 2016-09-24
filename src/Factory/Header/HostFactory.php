<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\HeaderFactoryInterface,
    Header\HeaderInterface,
    Header\HostValue,
    Header\Host,
    Exception\InvalidArgumentException
};
use Innmind\Url\Url;
use Innmind\Immutable\StringPrimitive as Str;

final class HostFactory implements HeaderFactoryInterface
{
    public function make(Str $name, Str $value): HeaderInterface
    {
        if ((string) $name->toLower() !== 'host') {
            throw new InvalidArgumentException;
        }

        $url = Url::fromString((string) $value);

        return new Host(
            new HostValue(
                $url->authority()->host(),
                $url->authority()->port()
            )
        );
    }
}

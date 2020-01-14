<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\HeaderFactory as HeaderFactoryInterface,
    Header,
    Header\HostValue,
    Header\Host,
    Exception\DomainException,
};
use Innmind\Url\Url;
use Innmind\Immutable\Str;

final class HostFactory implements HeaderFactoryInterface
{
    public function __invoke(Str $name, Str $value): Header
    {
        if ($name->toLower()->toString() !== 'host') {
            throw new DomainException($name->toString());
        }

        $url = Url::of('http://'.$value->toString());

        return new Host(
            new HostValue(
                $url->authority()->host(),
                $url->authority()->port(),
            ),
        );
    }
}

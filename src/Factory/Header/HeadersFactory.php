<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\HeadersFactory as HeadersFactoryInterface,
    Factory\HeaderFactory as HeaderFactoryInterface,
    Headers,
    Header
};
use Innmind\Immutable\{
    Map,
    Str
};

final class HeadersFactory implements HeadersFactoryInterface
{
    private $headerFactory;

    public function __construct(HeaderFactoryInterface $headerFactory)
    {
        $this->headerFactory = $headerFactory;
    }

    public function make(): Headers
    {
        $map = new Map('string', Header::class);

        foreach (getallheaders() as $name => $value) {
            $map = $map->put(
                $name,
                $this->headerFactory->make(
                    new Str((string) $name),
                    new Str((string) $value)
                )
            );
        }

        return new Headers\Headers($map);
    }
}

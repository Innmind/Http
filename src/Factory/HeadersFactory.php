<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory;

use Innmind\Http\{
    HeadersInterface,
    Headers,
    Header\HeaderInterface
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

    public function make(): HeadersInterface
    {
        $map = new Map('string', HeaderInterface::class);

        foreach (getallheaders() as $name => $value) {
            $map = $map->put(
                $name,
                $this->headerFactory->make(
                    new Str((string) $name),
                    new Str((string) $value)
                )
            );
        }

        return new Headers($map);
    }
}

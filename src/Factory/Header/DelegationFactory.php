<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\HeaderFactory as HeaderFactoryInterface,
    Header,
    Exception\DomainException,
};
use Innmind\Immutable\{
    Map,
    Str,
};

final class DelegationFactory implements HeaderFactoryInterface
{
    /** @var Map<string, HeaderFactoryInterface> */
    private Map $factories;

    /**
     * @param Map<string, HeaderFactoryInterface> $factories
     */
    public function __construct(Map $factories)
    {
        $this->factories = $factories;
    }

    public function __invoke(Str $name, Str $value): Header
    {
        return $this
            ->factories
            ->get($name->toLower()->toString())
            ->match(
                static fn($factory) => $factory($name, $value),
                static fn() => throw new DomainException($name->toString()),
            );
    }
}

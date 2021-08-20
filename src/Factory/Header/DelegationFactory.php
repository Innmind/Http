<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\HeaderFactory,
    Header,
};
use Innmind\Immutable\{
    Map,
    Str,
    Maybe,
};

final class DelegationFactory implements HeaderFactory
{
    /** @var Map<string, HeaderFactory> */
    private Map $factories;

    /**
     * @param Map<string, HeaderFactory> $factories
     */
    public function __construct(Map $factories)
    {
        $this->factories = $factories;
    }

    public function __invoke(Str $name, Str $value): Maybe
    {
        return $this
            ->factories
            ->get($name->toLower()->toString())
            ->flatMap(static fn($factory) => $factory($name, $value));
    }
}

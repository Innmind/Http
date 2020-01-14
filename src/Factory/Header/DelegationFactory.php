<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\HeaderFactory as HeaderFactoryInterface,
    Header,
};
use Innmind\Immutable\{
    Map,
    Str,
};
use function Innmind\Immutable\assertMap;

final class DelegationFactory implements HeaderFactoryInterface
{
    /** @var Map<string, HeaderFactoryInterface> */
    private Map $factories;

    /**
     * @param Map<string, HeaderFactoryInterface> $factories
     */
    public function __construct(Map $factories)
    {
        assertMap('string', HeaderFactoryInterface::class, $factories, 1);

        /** @var Map<string, HeaderFactoryInterface> */
        $this->factories = $factories;
    }

    public function __invoke(Str $name, Str $value): Header
    {
        return $this
            ->factories
            ->get($name->toLower()->toString())
            ($name, $value);
    }
}

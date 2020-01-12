<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\HeaderFactory as HeaderFactoryInterface,
    Header
};
use Innmind\Immutable\{
    MapInterface,
    Str
};

final class DelegationFactory implements HeaderFactoryInterface
{
    private MapInterface $factories;

    public function __construct(MapInterface $factories)
    {
        if (
            (string) $factories->keyType() !== 'string' ||
            (string) $factories->valueType() !== HeaderFactoryInterface::class
        ) {
            throw new \TypeError(sprintf(
                'Argument 1 must be of type MapInterface<string, %s>',
                HeaderFactoryInterface::class
            ));
        }

        $this->factories = $factories;
    }

    public function __invoke(Str $name, Str $value): Header
    {
        return $this
            ->factories
            ->get((string) $name->toLower())
            ($name, $value);
    }
}

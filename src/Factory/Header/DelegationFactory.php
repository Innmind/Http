<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\HeaderFactory as HeaderFactoryInterface,
    Header
};
use Innmind\Immutable\{
    Map,
    Str,
};

final class DelegationFactory implements HeaderFactoryInterface
{
    private Map $factories;

    public function __construct(Map $factories)
    {
        if (
            (string) $factories->keyType() !== 'string' ||
            (string) $factories->valueType() !== HeaderFactoryInterface::class
        ) {
            throw new \TypeError(sprintf(
                'Argument 1 must be of type Map<string, %s>',
                HeaderFactoryInterface::class
            ));
        }

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

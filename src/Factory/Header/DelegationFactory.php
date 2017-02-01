<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\HeaderFactoryInterface,
    Header\HeaderInterface,
    Exception\InvalidArgumentException
};
use Innmind\Immutable\{
    MapInterface,
    StringPrimitive as Str
};

final class DelegationFactory implements HeaderFactoryInterface
{
    private $factories;

    public function __construct(MapInterface $factories)
    {
        if (
            (string) $factories->keyType() !== 'string' ||
            (string) $factories->valueType() !== HeaderFactoryInterface::class
        ) {
            throw new InvalidArgumentException;
        }

        $this->factories = $factories;
    }

    public function make(Str $name, Str $value): HeaderInterface
    {
        return $this
            ->factories
            ->get((string) $name->toLower())
            ->make($name, $value);
    }
}

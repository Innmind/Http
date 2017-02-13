<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\HeaderFactoryInterface,
    Exception\InvalidArgumentException,
    Header\HeaderInterface,
    Header\HeaderValueInterface,
    Header\Header,
    Header\HeaderValue
};
use Innmind\Immutable\{
    MapInterface,
    Set,
    Str
};

/**
 * @deprecated
 */
final class DefaultFactory implements HeaderFactoryInterface
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

        @trigger_error(
            'Use the combination of HeaderFactory, DelegationFactory and TryFactory instead',
            E_USER_DEPRECATED
        );

        $this->factories = $factories;
    }

    public function make(Str $name, Str $value): HeaderInterface
    {
        if ($this->factories->contains((string) $name->toLower())) {
            return $this
                ->factories
                ->get((string) $name->toLower())
                ->make($name, $value);
        }

        $values = new Set(HeaderValueInterface::class);

        foreach ($value->split(',') as $headerValue) {
            $values = $values->add(
                new HeaderValue(
                    (string) $headerValue->trim()
                )
            );
        }

        return new Header(
            (string) $name,
            $values
        );
    }
}

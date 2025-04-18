<?php
declare(strict_types = 1);

namespace Innmind\Http\Header\Parameter;

use Innmind\Http\{
    Header\Parameter as ParameterInterface,
    Exception\DomainException
};
use Innmind\Immutable\Maybe;

/**
 * @psalm-immutable
 */
final class Quality implements ParameterInterface
{
    private Parameter $parameter;

    public function __construct(float $value)
    {
        if ($value < 0 || $value > 1) {
            throw new DomainException((string) $value);
        }

        $this->parameter = new Parameter('q', (string) $value);
    }

    /**
     * @psalm-pure
     *
     * @return Maybe<self>
     */
    public static function of(float $value): Maybe
    {
        try {
            return Maybe::just(new self($value));
        } catch (DomainException $e) {
            /** @var Maybe<self> */
            return Maybe::nothing();
        }
    }

    #[\Override]
    public function name(): string
    {
        return $this->parameter->name();
    }

    #[\Override]
    public function value(): string
    {
        return $this->parameter->value();
    }

    #[\Override]
    public function toString(): string
    {
        return $this->parameter->toString();
    }
}

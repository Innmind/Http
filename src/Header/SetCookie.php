<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\{
    Header,
    Header\SetCookie\Directive,
    Header\SetCookie\Domain,
    Header\SetCookie\Expires,
    Header\SetCookie\MaxAge,
    Header\SetCookie\Path,
};
use Innmind\Immutable\{
    Sequence,
    Str,
};

/**
 * @psalm-immutable
 */
final class SetCookie implements Custom
{
    /**
     * @param Sequence<Directive|Domain|Expires|MaxAge|Path> $parameters
     * @param Sequence<self> $others
     */
    private function __construct(
        private Parameter $value,
        private Sequence $parameters,
        private Sequence $others,
    ) {
    }

    /**
     * @no-named-arguments
     * @psalm-pure
     */
    public static function of(
        string $name,
        string $value,
        Directive|Domain|Expires|MaxAge|Path ...$parameters,
    ): self {
        return new self(
            new Parameter\Parameter($name, $value),
            Sequence::of(...$parameters),
            Sequence::of(),
        );
    }

    public function and(self $cookie): self
    {
        return new self(
            $this->value,
            $this->parameters,
            ($this->others)($cookie),
        );
    }

    public function name(): string
    {
        return $this->value->name();
    }

    public function value(): string
    {
        return $this->value->value();
    }

    /**
     * @return Sequence<Directive|Domain|Expires|MaxAge|Path>
     */
    public function parameters(): Sequence
    {
        return $this->parameters;
    }

    /**
     * @return Sequence<self>
     */
    public function cookies(): Sequence
    {
        return Sequence::of($this)->append($this->others);
    }

    #[\Override]
    public function normalize(): Header
    {
        return new Header(
            'Set-Cookie',
            ...$this
                ->cookies()
                ->map(static fn($self) => new Value(
                    Str::of('; ')
                        ->join(
                            Sequence::of($self->value)
                                ->append($self->parameters->map(
                                    static fn($parameter) => $parameter->toParameter(),
                                ))
                                ->map(static fn($parameter) => $parameter->toString()),
                        )
                        ->toString(),
                ))
                ->toList(),
        );
    }
}

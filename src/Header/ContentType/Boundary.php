<?php
declare(strict_types = 1);

namespace Innmind\Http\Header\ContentType;

use Innmind\Http\{
    Header\ContentType,
    Header\Parameter,
    Exception\DomainException,
};
use Innmind\MediaType;
use Innmind\Immutable\{
    Str,
    Maybe,
};
use Ramsey\Uuid\Uuid;

/**
 * @psalm-immutable
 */
final class Boundary
{
    private function __construct(
        private string $value,
    ) {
    }

    /**
     * @psalm-pure
     *
     * @param non-empty-string $value
     *
     * @throws DomainException
     */
    public static function of(string $value): self
    {
        return self::maybe($value)->match(
            static fn($self) => $self,
            static fn() => throw new DomainException($value),
        );
    }

    /**
     * @psalm-pure
     *
     * @return Maybe<self>
     */
    public static function maybe(string $value): Maybe
    {
        return Str::of($value)
            ->maybe(static fn($value) => !$value->endsWith(' '))
            ->filter(static fn($value) => $value->matches(
                '~^[a-zA-Z0-9 \'()+_,-./:=?]{1,70}$~',
            ))
            ->map(static fn($value) => new self($value->toString()));
    }

    public static function uuid(): self
    {
        return self::of(Uuid::uuid4()->toString());
    }

    public function value(): string
    {
        return $this->value;
    }

    public function toHeader(): ContentType
    {
        return ContentType::of(MediaType\MediaType::from(
            MediaType\TopLevel::multipart,
            'form-data',
            '',
            MediaType\Parameter::from(
                'boundary',
                $this->value,
            ),
        ));
    }

    public function toParameter(): Parameter
    {
        return Parameter::of('boundary', $this->value);
    }
}

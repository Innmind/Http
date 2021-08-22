<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Exception\DomainException;
use Innmind\Immutable\{
    Str,
    Map,
    Maybe,
};
use function Innmind\Immutable\join;

/**
 * @psalm-immutable
 */
final class ContentTypeValue implements Value
{
    private string $type;
    private string $subType;
    /** @var Map<string, Parameter> */
    private Map $parameters;

    public function __construct(
        string $type,
        string $subType,
        Parameter ...$parameters,
    ) {
        $media = Str::of('%s/%s')->sprintf($type, $subType);
        /** @var Map<string, Parameter> */
        $this->parameters = Map::of();

        if (!$media->matches('~^[\w\-.]+/[\w\-.]+$~')) {
            throw new DomainException($media->toString());
        }

        foreach ($parameters as $parameter) {
            $this->parameters = ($this->parameters)(
                $parameter->name(),
                $parameter,
            );
        }

        $this->type = $type;
        $this->subType = $subType;
    }

    /**
     * @psalm-pure
     *
     * @return Maybe<self>
     */
    public static function of(
        string $type,
        string $subType,
        Parameter ...$parameters,
    ): Maybe {
        try {
            return Maybe::just(new self($type, $subType, ...$parameters));
        } catch (DomainException $e) {
            /** @var Maybe<self> */
            return Maybe::nothing();
        }
    }

    public function type(): string
    {
        return $this->type;
    }

    public function subType(): string
    {
        return $this->subType;
    }

    /**
     * @return Map<string, Parameter>
     */
    public function parameters(): Map
    {
        return $this->parameters;
    }

    public function toString(): string
    {
        $parameters = $this->parameters->values()->map(
            static fn($paramater) => $paramater->toString(),
        );
        $parameters = join(';', $parameters);
        $parameters = !$parameters->empty() ? $parameters->prepend(';') : $parameters;

        return Str::of($this->type)
            ->append('/')
            ->append($this->subType)
            ->append($parameters->toString())
            ->toString();
    }
}

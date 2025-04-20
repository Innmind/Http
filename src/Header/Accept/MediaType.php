<?php
declare(strict_types = 1);

namespace Innmind\Http\Header\Accept;

use Innmind\Http\{
    Header\Parameter,
};
use Innmind\Immutable\{
    Str,
    Map,
    Maybe,
};

/**
 * @psalm-immutable
 */
final class MediaType
{
    private function __construct(
        private string $type,
        private string $subType,
        /** @var Map<string, Parameter> */
        private Map $parameters,
    ) {
    }

    /**
     * @psalm-pure
     *
     * @return Maybe<self>
     */
    public static function maybe(
        string $type,
        string $subType,
        Parameter ...$parameters,
    ): Maybe {
        $media = Str::of('%s/%s')->sprintf($type, $subType);

        if (
            !$media->matches('~^\*/\*$~') &&
            !$media->matches('~^[\w\-.]+/\*$~') &&
            !$media->matches('~^[\w\-.]+/[\w\-.]+$~')
        ) {
            /** @var Maybe<self> */
            return Maybe::nothing();
        }

        /** @var Map<string, Parameter> */
        $map = Map::of();

        foreach ($parameters as $parameter) {
            $map = ($map)(
                $parameter->name(),
                $parameter,
            );
        }

        return Maybe::just(new self($type, $subType, $map));
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
        $parameters = Str::of(';')->join($parameters);
        $parameters = !$parameters->empty() ? $parameters->prepend(';') : $parameters;

        return Str::of($this->type)
            ->append('/')
            ->append($this->subType)
            ->append($parameters->toString())
            ->toString();
    }
}

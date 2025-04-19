<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Header;

use Innmind\Immutable\{
    Map,
    Str,
    Maybe,
};

/**
 * @internal
 * @psalm-immutable
 */
final class DelegationFactory implements Implementation
{
    /**
     * @param Map<string, Implementation> $factories
     */
    public function __construct(
        private Map $factories,
    ) {
    }

    #[\Override]
    public function __invoke(Str $name, Str $value): Maybe
    {
        return $this
            ->factories
            ->get($name->toLower()->toString())
            ->flatMap(static fn($factory) => $factory($name, $value));
    }
}

<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory;

use Innmind\Http\{
    ServerRequest\Form,
    Factory\Form\Native,
};

/**
 * @psalm-immutable
 */
final class FormFactory
{
    /**
     * @param Native|pure-Closure(): Form $implementation
     */
    private function __construct(
        private Native|\Closure $implementation,
    ) {
    }

    #[\NoDiscard]
    public function __invoke(): Form
    {
        return ($this->implementation)();
    }

    #[\NoDiscard]
    public static function native(): self
    {
        return new self(Native::new());
    }

    /**
     * @psalm-pure
     *
     * @param pure-Closure(): Form $factory
     */
    #[\NoDiscard]
    public static function of(\Closure $factory): self
    {
        return new self($factory);
    }
}

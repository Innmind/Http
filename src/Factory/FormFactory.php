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

    public function __invoke(): Form
    {
        return ($this->implementation)();
    }

    public static function native(): self
    {
        return new self(Native::new());
    }

    /**
     * @psalm-pure
     *
     * @param pure-Closure(): Form $factory
     */
    public static function of(\Closure $factory): self
    {
        return new self($factory);
    }
}

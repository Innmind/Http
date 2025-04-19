<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory;

use Innmind\Http\{
    ServerRequest\Form,
    Factory\Form\Defaut,
};

/**
 * @psalm-immutable
 */
final class FormFactory
{
    /**
     * @param Defaut|pure-Closure(): Form $implementation
     */
    private function __construct(
        private Defaut|\Closure $implementation,
    ) {
    }

    public function __invoke(): Form
    {
        return ($this->implementation)();
    }

    public static function default(): self
    {
        return new self(Defaut::new());
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

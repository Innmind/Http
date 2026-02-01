<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory;

use Innmind\Http\{
    ServerRequest\Files,
    Factory\Files\Native,
};
use Innmind\IO\IO;

/**
 * @psalm-immutable
 */
final class FilesFactory
{
    /**
     * @param Native|pure-Closure(): Files $implementation
     */
    private function __construct(
        private Native|\Closure $implementation,
    ) {
    }

    #[\NoDiscard]
    public function __invoke(): Files
    {
        return ($this->implementation)();
    }

    #[\NoDiscard]
    public static function native(IO $io): self
    {
        return new self(Native::new($io));
    }

    /**
     * @psalm-pure
     *
     * @param pure-Closure(): Files $factory
     */
    #[\NoDiscard]
    public static function of(\Closure $factory): self
    {
        return new self($factory);
    }
}

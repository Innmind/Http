<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory;

use Innmind\Http\{
    ServerRequest\Files,
    Factory\Files\Defaut,
};
use Innmind\IO\IO;

/**
 * @psalm-immutable
 */
final class FilesFactory
{
    /**
     * @param Defaut|pure-Closure(): Files $implementation
     */
    private function __construct(
        private Defaut|\Closure $implementation,
    ) {
    }

    public function __invoke(): Files
    {
        return ($this->implementation)();
    }

    public static function default(IO $io): self
    {
        return new self(Defaut::new($io));
    }

    /**
     * @psalm-pure
     *
     * @param pure-Closure(): Files $factory
     */
    public static function of(\Closure $factory): self
    {
        return new self($factory);
    }
}

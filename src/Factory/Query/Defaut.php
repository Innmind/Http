<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Query;

use Innmind\Http\ServerRequest\Query;

/**
 * @internal
 * @psalm-immutable
 */
final class Defaut
{
    /**
     * @param array<string, string|array> $get
     */
    private function __construct(
        private array $get,
    ) {
    }

    public function __invoke(): Query
    {
        return Query::of($this->get);
    }

    public static function new(): self
    {
        /** @var array<string, string|array> */
        $get = $_GET;

        return new self($get);
    }
}

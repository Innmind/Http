<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory;

use Innmind\Http\ServerRequest\Query;

/**
 * @psalm-immutable
 */
interface QueryFactory
{
    public function __invoke(): Query;
}

<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory;

use Innmind\Http\Message\ServerRequest;

/**
 * @psalm-immutable
 */
interface ServerRequestFactory
{
    public function __invoke(): ServerRequest;
}

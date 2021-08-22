<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory;

use Innmind\Http\Message\Environment;

/**
 * @psalm-immutable
 */
interface EnvironmentFactory
{
    public function __invoke(): Environment;
}

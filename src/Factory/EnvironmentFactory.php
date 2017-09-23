<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory;

use Innmind\Http\Message\Environment;

interface EnvironmentFactory
{
    public function make(): Environment;
}

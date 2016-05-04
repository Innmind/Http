<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory;

use Innmind\Http\Message\EnvironmentInterface;

interface EnvironmentFactoryInterface
{
    public function make(): EnvironmentInterface;
}

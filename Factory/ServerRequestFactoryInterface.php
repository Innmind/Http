<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory;

use Innmind\Http\Message\ServerRequestInterface;

interface ServerRequestFactoryInterface
{
    public function make(): ServerRequestInterface;
}

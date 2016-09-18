<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory;

use Innmind\Http\HeadersInterface;

interface HeadersFactoryInterface
{
    public function make(): HeadersInterface;
}

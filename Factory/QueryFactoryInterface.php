<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory;

use Innmind\Http\Message\QueryInterface;

interface QueryFactoryInterface
{
    public function make(): QueryInterface;
}

<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory;

use Innmind\Http\Headers;

/**
 * @psalm-immutable
 */
interface HeadersFactory
{
    public function __invoke(): Headers;
}

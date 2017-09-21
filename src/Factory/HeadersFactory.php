<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory;

use Innmind\Http\Headers;

interface HeadersFactory
{
    public function make(): Headers;
}
